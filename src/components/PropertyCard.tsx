import Link from "next/link";
import { Star, MapPin, Users, Bed, Bath } from "lucide-react";

export interface Property {
  id: number;
  title: string;
  description?: string;
  address: string;
  price: number;
  beds: number;
  baths: number;
  guests: number;
  rating?: number;
  reviews_count?: number;
  primary_image?: string;
  type_name?: string;
}

export default function PropertyCard({ property }: { property: Property }) {
  const { id, title, address, price, beds, baths, guests, rating, reviews_count, primary_image, type_name } = property;

  return (
    <Link href={`/propiedad/${id}`} style={{ textDecoration: "none", color: "inherit" }}>
      <article className="card">
        <div className="card-image">
          {primary_image
            ? <img src={primary_image} alt={title} loading="lazy" />
            : <div className="card-image-placeholder">🏠</div>
          }
          {type_name && <span className="card-badge">{type_name}</span>}
          {rating != null && (
            <span className="card-rating">
              <Star size={12} style={{ fill: "#FFD700", color: "#FFD700" }} />
              {rating.toFixed(1)}
            </span>
          )}
        </div>

        <div className="card-body">
          <h3 className="card-title">{title}</h3>
          <p className="card-address">
            <MapPin size={13} /> {address}
          </p>
          <div className="card-meta">
            <span className="card-meta-item"><Bed size={13} /> {beds} hab.</span>
            <span className="card-meta-item"><Bath size={13} /> {baths} baño{baths !== 1 ? "s" : ""}</span>
            <span className="card-meta-item"><Users size={13} /> {guests} huésp.</span>
          </div>
          <div className="card-footer">
            <div>
              <span className="card-price">${price.toLocaleString("es-AR")}</span>
              <span className="card-price-unit"> /noche</span>
            </div>
            {reviews_count != null && (
              <span className="card-reviews">{reviews_count} reseña{reviews_count !== 1 ? "s" : ""}</span>
            )}
          </div>
        </div>
      </article>
    </Link>
  );
}
