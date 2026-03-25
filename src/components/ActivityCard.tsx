import Link from "next/link";
import { Star, MapPin } from "lucide-react";

export interface Activity {
  id: number;
  name: string;
  slug: string;
  description?: string;
  category: string;
  rating?: number;
  image?: string;
  tags?: string[];
}

interface ActivityCardProps {
  activity: Activity;
}

const categoryColors: Record<string, string> = {
  restaurant: "#F59E0B",
  teatro: "#8B5CF6",
  parque: "#10B981",
  museo: "#3B82F6",
  aventura: "#EF4444",
  playa: "#06B6D4",
  default: "#FF6B35",
};

export default function ActivityCard({ activity }: ActivityCardProps) {
  const { slug, name, description, category, rating, image } = activity;
  const color = categoryColors[category.toLowerCase()] ?? categoryColors.default;

  return (
    <Link href={`/actividad/${slug}`} style={{ textDecoration: "none", color: "inherit", display: "block" }}>
      <article
        style={{
          background: "#fff",
          borderRadius: 20,
          overflow: "hidden",
          boxShadow: "0 4px 24px rgba(0,0,0,0.08)",
          border: "1px solid #EEEEEE",
          transition: "all 0.3s cubic-bezier(0.4,0,0.2,1)",
          cursor: "pointer",
        }}
        onMouseEnter={e => {
          (e.currentTarget as HTMLElement).style.transform = "translateY(-6px)";
          (e.currentTarget as HTMLElement).style.boxShadow = "0 16px 40px rgba(0,0,0,0.15)";
        }}
        onMouseLeave={e => {
          (e.currentTarget as HTMLElement).style.transform = "translateY(0)";
          (e.currentTarget as HTMLElement).style.boxShadow = "0 4px 24px rgba(0,0,0,0.08)";
        }}
      >
        <div style={{ position: "relative", height: 200, background: "#F5F5F5", overflow: "hidden" }}>
          {image ? (
            <img src={image} alt={name} style={{ width: "100%", height: "100%", objectFit: "cover" }} loading="lazy" />
          ) : (
            <div style={{ width: "100%", height: "100%", display: "flex", alignItems: "center", justifyContent: "center", background: `linear-gradient(135deg,${color},${color}99)`, fontSize: "3rem" }}>
              🎯
            </div>
          )}
          <span style={{
            position: "absolute", top: 12, left: 12,
            background: color, color: "#fff",
            padding: "0.3rem 0.75rem", borderRadius: 50,
            fontSize: "0.78rem", fontWeight: 600, fontFamily: "Poppins, sans-serif",
            textTransform: "capitalize",
          }}>
            {category}
          </span>
          {rating && (
            <span style={{
              position: "absolute", top: 12, right: 12,
              background: "rgba(0,0,0,0.7)", color: "#fff",
              padding: "0.3rem 0.6rem", borderRadius: 50,
              fontSize: "0.78rem", fontWeight: 600, display: "flex", alignItems: "center", gap: "0.25rem",
            }}>
              <Star size={12} style={{ fill: "#FFD700", color: "#FFD700" }} />
              {rating.toFixed(1)}
            </span>
          )}
        </div>

        <div style={{ padding: "1.25rem" }}>
          <h3 style={{
            fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1rem",
            color: "#212121", marginBottom: "0.5rem", lineHeight: 1.3,
          }}>
            {name}
          </h3>
          {description && (
            <p style={{
              fontSize: "0.875rem", color: "#757575", lineHeight: 1.5,
              display: "-webkit-box", WebkitLineClamp: 2, WebkitBoxOrient: "vertical", overflow: "hidden",
            }}>
              {description}
            </p>
          )}
        </div>
      </article>
    </Link>
  );
}
