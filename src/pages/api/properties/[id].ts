import type { NextApiRequest, NextApiResponse } from "next";
import { db } from "~/server/db";

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  if (req.method !== "GET") return res.status(405).end();

  const { id } = req.query;
  const numId = parseInt(id as string);
  if (isNaN(numId)) return res.status(400).json({ error: "Invalid ID" });

  try {
    const property = await (db as unknown as {
      property: {
        findUnique: (args: unknown) => Promise<unknown>;
      }
    }).property.findUnique({
      where: { id: numId },
      include: {
        images: { select: { url: true, is_primary: true } },
        amenities: { select: { name: true, icon: true } },
        reviews: {
          where: { status: "approved" },
          select: { id: true, author: true, rating: true, text: true, created_at: true },
          take: 10,
        },
      },
    });

    if (!property) return res.status(404).json({ error: "Not found" });
    res.status(200).json(property);
  } catch {
    res.status(404).json({ error: "Not found" });
  }
}
