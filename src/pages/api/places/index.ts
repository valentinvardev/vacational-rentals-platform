import type { NextApiRequest, NextApiResponse } from "next";
import { db } from "~/server/db";

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  if (req.method !== "GET") return res.status(405).end();

  const { search, category } = req.query;

  try {
    const where: Record<string, unknown> = { status: "active" };

    if (search) {
      where.OR = [
        { name: { contains: search as string, mode: "insensitive" } },
        { description: { contains: search as string, mode: "insensitive" } },
      ];
    }

    if (category) {
      where.category = { equals: category as string, mode: "insensitive" };
    }

    const places = await (db as unknown as {
      place: {
        findMany: (args: unknown) => Promise<unknown[]>;
      }
    }).place.findMany({
      where,
      take: 50,
      orderBy: { name: "asc" },
      select: {
        id: true,
        name: true,
        slug: true,
        description: true,
        category: true,
        rating: true,
        image: true,
      },
    });

    res.status(200).json({ data: places });
  } catch {
    res.status(200).json({ data: [] });
  }
}
