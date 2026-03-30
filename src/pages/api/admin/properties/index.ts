import type { NextApiRequest, NextApiResponse } from "next";
import { db } from "~/server/db";

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const prisma = db as any;

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  if (req.method === "GET") {
    try {
      const properties = await prisma.property.findMany({
        orderBy: { createdAt: "desc" },
        include: {
          images: { where: { is_primary: true }, take: 1 },
          _count: { select: { reviews: true, amenities: true } },
        },
      });
      const total = properties.length;
      const active = properties.filter((p: { status: string }) => p.status === "active").length;
      const avgPrice = total > 0
        ? Math.round(properties.reduce((sum: number, p: { price: number }) => sum + p.price, 0) / total)
        : 0;
      const totalReviews = properties.reduce(
        (sum: number, p: { reviews_count: number }) => sum + (p.reviews_count ?? 0),
        0,
      );
      return res.status(200).json({ data: properties, stats: { total, active, avgPrice, totalReviews } });
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error fetching properties" });
    }
  }

  if (req.method === "POST") {
    try {
      const { amenities, images, ...data } = req.body as {
        amenities?: { name: string; icon?: string }[];
        images?: { url: string; is_primary: boolean }[];
        [key: string]: unknown;
      };

      const property = await prisma.property.create({
        data: {
          title: data.title,
          description: data.description ?? null,
          address: data.address,
          price: parseInt(String(data.price)),
          beds: parseInt(String(data.beds)),
          baths: parseInt(String(data.baths)),
          guests: parseInt(String(data.guests)),
          rating: data.rating ? parseFloat(String(data.rating)) : null,
          reviews_count: 0,
          type_name: data.type_name ?? null,
          status: data.status ?? "active",
          lat: data.lat ? parseFloat(String(data.lat)) : null,
          lng: data.lng ? parseFloat(String(data.lng)) : null,
          amenities: amenities?.length ? { create: amenities } : undefined,
          images: images?.length ? { create: images } : undefined,
        },
      });
      return res.status(201).json(property);
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error creating property" });
    }
  }

  return res.status(405).end();
}
