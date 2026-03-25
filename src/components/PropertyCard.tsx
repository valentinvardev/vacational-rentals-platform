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

interface PropertyCardProps {
  property: Property;
}

export default function PropertyCard({ property }: PropertyCardProps) {
  const { id, title, address, price, beds, baths, guests, rating, reviews_count, primary_image, type_name } = property;

  return (
    <Link
      href={`/propiedad/${id}`}
      style={{ textDecoration: "none", color: "inherit", display: "block" }}
    >
      <article
        style={{
          background: "#fff",
          borderRadius: 20,
          overflow: "hidden",
          boxShadow: "0 4px 24px rgba(0,0,0,0.08)",
          transition: "all 0.3s cubic-bezier(0.4,0,0.2,1)",
          cursor: "pointer",
          border: "1px solid #EEEEEE",
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
        {/* Image */}
        <div style={{ position: "relative", height: 220, background: "#F5F5F5", overflow: "hidden" }}>
          {primary_image ? (
            <img
              src={primary_image}
              alt={title}
              style={{ width: "100%", height: "100%", objectFit: "cover", transition: "transform 0.4s ease" }}
              loading="lazy"
            />
          ) : (
            <div style={{ width: "100%", height: "100%", display: "flex", alignItems: "center", justifyContent: "center", background: "linear-gradient(135deg,#FF6B35,#FF8F64)", color: "#fff", fontSize: "3rem" }}>
              🏠
            </div>
          )}
          {type_name && (
            <span style={{
              position: "absolute", top: 12, left: 12,
              background: "rgba(255,107,53,0.95)", color: "#fff",
              padding: "0.3rem 0.75rem", borderRadius: 50,
              fontSize: "0.78rem", fontWeight: 600, fontFamily: "Poppins, sans-serif",
            }}>
              {type_name}
            </span>
          )}
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

        {/* Content */}
        <div style={{ padding: "1.25rem" }}>
          <h3 style={{
            fontFamily: "Poppins, sans-serif", fontWeight: 700,
            fontSize: "1rem", color: "#212121",
            marginBottom: "0.4rem", lineHeight: 1.3,
            display: "-webkit-box", WebkitLineClamp: 2, WebkitBoxOrient: "vertical", overflow: "hidden",
          }}>
            {title}
          </h3>

          <p style={{ display: "flex", alignItems: "center", gap: "0.3rem", fontSize: "0.85rem", color: "#757575", marginBottom: "1rem" }}>
            <MapPin size={13} />
            {address}
          </p>

          <div style={{ display: "flex", gap: "1rem", marginBottom: "1rem" }}>
            {[
              { Icon: Bed, value: `${beds} ${beds === 1 ? "hab." : "habs."}` },
              { Icon: Bath, value: `${baths} ${baths === 1 ? "baño" : "baños"}` },
              { Icon: Users, value: `${guests} huésp.` },
            ].map(({ Icon, value }) => (
              <span key={value} style={{ display: "flex", alignItems: "center", gap: "0.3rem", fontSize: "0.82rem", color: "#757575" }}>
                <Icon size={13} />
                {value}
              </span>
            ))}
          </div>

          <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", borderTop: "1px solid #EEEEEE", paddingTop: "0.875rem" }}>
            <div>
              <span style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "1.1rem", color: "#FF6B35" }}>
                ${price.toLocaleString("es-AR")}
              </span>
              <span style={{ fontSize: "0.8rem", color: "#757575" }}> /noche</span>
            </div>
            {reviews_count != null && (
              <span style={{ fontSize: "0.8rem", color: "#757575" }}>
                {reviews_count} {reviews_count === 1 ? "reseña" : "reseñas"}
              </span>
            )}
          </div>
        </div>
      </article>
    </Link>
  );
}
