import Link from "next/link";
import { Star } from "lucide-react";

export interface Activity {
  id: number;
  name: string;
  slug: string;
  description?: string;
  category: string;
  rating?: number;
  image?: string;
}

const CAT_COLORS: Record<string, string> = {
  restaurant: "#F59E0B",
  teatro: "#8B5CF6",
  parque: "#10B981",
  museo: "#3B82F6",
  aventura: "#EF4444",
  playa: "#06B6D4",
};

export default function ActivityCard({ activity }: { activity: Activity }) {
  const { slug, name, description, category, rating, image } = activity;
  const color = CAT_COLORS[category.toLowerCase()] ?? "#FF6B35";

  return (
    <Link href={`/actividad/${slug}`} style={{ textDecoration: "none", color: "inherit" }}>
      <article className="card">
        <div className="card-image" style={{ background: `linear-gradient(135deg,${color}99,${color})` }}>
          {image
            ? <img src={image} alt={name} loading="lazy" />
            : <div className="card-image-placeholder">🎯</div>
          }
          <span className="card-badge" style={{ background: color }}>{category}</span>
          {rating != null && (
            <span className="card-rating">
              <Star size={12} style={{ fill: "#FFD700", color: "#FFD700" }} />
              {rating.toFixed(1)}
            </span>
          )}
        </div>

        <div className="card-body">
          <h3 className="card-title">{name}</h3>
          {description && (
            <p style={{ fontSize: ".875rem", color: "var(--gray-500)", lineHeight: 1.55, display: "-webkit-box", WebkitLineClamp: 2, WebkitBoxOrient: "vertical", overflow: "hidden" }}>
              {description}
            </p>
          )}
        </div>
      </article>
    </Link>
  );
}
