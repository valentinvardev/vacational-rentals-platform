import type { NextApiRequest, NextApiResponse } from "next";
import { db } from "~/server/db";

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const prisma = db as any;

function toUTC(dateStr: string) {
  const [y, m, d] = dateStr.split("-").map(Number);
  return new Date(Date.UTC(y!, m! - 1, d!));
}

function dateRange(start: string, end: string): string[] {
  const dates: string[] = [];
  const cur = toUTC(start);
  const last = toUTC(end);
  while (cur <= last) {
    dates.push(cur.toISOString().split("T")[0]!);
    cur.setUTCDate(cur.getUTCDate() + 1);
  }
  return dates;
}

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  const propertyId = parseInt(req.query.id as string);
  if (isNaN(propertyId)) return res.status(400).json({ error: "Invalid ID" });

  if (req.method === "GET") {
    const { start_date, end_date } = req.query;
    try {
      const where: Record<string, unknown> = { propertyId };
      if (start_date && end_date) {
        where.date = { gte: toUTC(start_date as string), lte: toUTC(end_date as string) };
      }
      const data = await prisma.propertyAvailability.findMany({
        where,
        orderBy: { date: "asc" },
      });
      return res.status(200).json({ data });
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error fetching availability" });
    }
  }

  if (req.method === "POST") {
    try {
      const { action, dates, start_date, end_date, price, notes } = req.body as {
        action: "block" | "unblock" | "price";
        dates?: string[];
        start_date?: string;
        end_date?: string;
        price?: number;
        notes?: string;
      };

      const targetDates: string[] =
        dates?.length
          ? dates
          : start_date && end_date
          ? dateRange(start_date, end_date)
          : [];

      if (!targetDates.length) return res.status(400).json({ error: "No dates provided" });

      if (action === "unblock") {
        await prisma.propertyAvailability.deleteMany({
          where: { propertyId, date: { in: targetDates.map(toUTC) } },
        });
        return res.status(200).json({ success: true });
      }

      const newStatus = action === "block" ? "blocked" : "available";
      await Promise.all(
        targetDates.map((d) =>
          prisma.propertyAvailability.upsert({
            where: { propertyId_date: { propertyId, date: toUTC(d) } },
            update: {
              status: newStatus,
              price: action === "price" ? (price ?? null) : undefined,
              notes: notes ?? null,
            },
            create: {
              propertyId,
              date: toUTC(d),
              status: newStatus,
              price: action === "price" ? (price ?? null) : null,
              notes: notes ?? null,
            },
          }),
        ),
      );
      return res.status(200).json({ success: true });
    } catch (e) {
      console.error(e);
      return res.status(500).json({ error: "Error updating availability" });
    }
  }

  return res.status(405).end();
}
