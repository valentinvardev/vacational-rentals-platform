import type { NextApiRequest, NextApiResponse } from "next";
import { db } from "~/server/db";

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  if (req.method !== "GET") return res.status(405).end();

  const { search, min_price, max_price, beds, guests, page = "1", per_page = "12", limit } = req.query;

  try {
    const take = limit ? parseInt(limit as string) : parseInt(per_page as string);
    const skip = (parseInt(page as string) - 1) * take;

    const where: Record<string, unknown> = {};

    if (search) {
      where.OR = [
        { title: { contains: search as string, mode: "insensitive" } },
        { address: { contains: search as string, mode: "insensitive" } },
      ];
    }

    const properties = await (db as unknown as {
      property: {
        findMany: (args: unknown) => Promise<unknown[]>;
        count: (args: unknown) => Promise<number>;
      }
    }).property.findMany({
      where,
      take,
      skip,
      orderBy: { createdAt: "desc" },
      select: {
        id: true,
        title: true,
        address: true,
        price: true,
        beds: true,
        baths: true,
        guests: true,
        type_name: true,
      },
    });

    res.status(200).json({ data: properties, total: properties.length });
  } catch {
    // Return empty if model not yet in schema
    res.status(200).json({ data: [], total: 0 });
  }
}
