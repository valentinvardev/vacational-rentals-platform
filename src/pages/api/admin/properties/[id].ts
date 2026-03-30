import type { NextApiRequest, NextApiResponse } from "next";
import { db } from "~/server/db";

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const prisma = db as any;

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  const id = parseInt(req.query.id as string);
  if (isNaN(id)) return res.status(400).json({ error: "Invalid ID" });

  if (req.method === "GET") {
    try {
      const property = await prisma.property.findUnique({
        where: { id },
        include: {
          images: true,
          amenities: true,
          reviews: { orderBy: { created_at: "desc" } },
        },
      });
      if (!property) return res.status(404).json({ error: "Not found" });
      return res.status(200).json(property);
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error fetching property" });
    }
  }

  if (req.method === "PUT") {
    try {
      const { amenities, images, ...data } = req.body as {
        amenities?: { name: string; icon?: string }[];
        images?: { url: string; is_primary: boolean }[];
        [key: string]: unknown;
      };

      // Delete existing related records then recreate
      await prisma.propertyAmenity.deleteMany({ where: { propertyId: id } });
      await prisma.propertyImage.deleteMany({ where: { propertyId: id } });

      const property = await prisma.property.update({
        where: { id },
        data: {
          title: data.title,
          description: data.description ?? null,
          address: data.address,
          price: parseInt(String(data.price)),
          beds: parseInt(String(data.beds)),
          baths: parseInt(String(data.baths)),
          guests: parseInt(String(data.guests)),
          rating: data.rating ? parseFloat(String(data.rating)) : null,
          type_name: data.type_name ?? null,
          status: data.status ?? "active",
          lat: data.lat ? parseFloat(String(data.lat)) : null,
          lng: data.lng ? parseFloat(String(data.lng)) : null,
          amenities: amenities?.length ? { create: amenities } : undefined,
          images: images?.length ? { create: images } : undefined,
        },
      });
      return res.status(200).json(property);
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error updating property" });
    }
  }

  if (req.method === "DELETE") {
    try {
      await prisma.property.delete({ where: { id } });
      return res.status(204).end();
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error deleting property" });
    }
  }

  return res.status(405).end();
}
