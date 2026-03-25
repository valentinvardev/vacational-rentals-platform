import Head from "next/head";
import Link from "next/link";
import { useRouter } from "next/router";
import { useEffect, useState } from "react";
import { Star, MapPin, Users, Bed, Bath, ArrowLeft, ChevronLeft, ChevronRight, Wifi, Tv, Car, Waves, Wind, Coffee } from "lucide-react";

interface Review {
  id: number;
  author: string;
  rating: number;
  text: string;
  created_at: string;
}

interface PropertyDetail {
  id: number;
  title: string;
  description: string;
  address: string;
  price: number;
  beds: number;
  baths: number;
  guests: number;
  rating?: number;
  reviews_count?: number;
  latitude?: number;
  longitude?: number;
  type_name?: string;
  images?: { url: string; is_primary: boolean }[];
  amenities?: { name: string; icon?: string }[];
  reviews?: Review[];
}

const AMENITY_ICONS: Record<string, React.ReactNode> = {
  wifi: <Wifi size={18} />,
  tv: <Tv size={18} />,
  parking: <Car size={18} />,
  pool: <Waves size={18} />,
  ac: <Wind size={18} />,
  breakfast: <Coffee size={18} />,
};

export default function PropiedadPage() {
  const router = useRouter();
  const { id } = router.query;
  const [property, setProperty] = useState<PropertyDetail | null>(null);
  const [loading, setLoading] = useState(true);
  const [imgIndex, setImgIndex] = useState(0);
  const [notFound, setNotFound] = useState(false);

  useEffect(() => {
    if (!id) return;
    fetch(`/api/properties/${id as string}`)
      .then(r => {
        if (!r.ok) { setNotFound(true); return null; }
        return r.json() as Promise<PropertyDetail>;
      })
      .then(data => { if (data) setProperty(data); })
      .catch(() => setNotFound(true))
      .finally(() => setLoading(false));
  }, [id]);

  const images = property?.images ?? [];
  const prevImg = () => setImgIndex(i => (i - 1 + images.length) % images.length);
  const nextImg = () => setImgIndex(i => (i + 1) % images.length);

  if (loading) return (
    <div style={{ display: "flex", alignItems: "center", justifyContent: "center", minHeight: "60vh" }}>
      <div style={{ width: 48, height: 48, border: "4px solid #EEEEEE", borderTopColor: "#FF6B35", borderRadius: "50%", animation: "spin 0.8s linear infinite" }} />
      <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
    </div>
  );

  if (notFound || !property) return (
    <div style={{ textAlign: "center", padding: "6rem 2rem" }}>
      <h1 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "2rem", marginBottom: "1rem" }}>Propiedad no encontrada</h1>
      <Link href="/busqueda" style={{ color: "#FF6B35", fontWeight: 600 }}>Ver todos los hospedajes</Link>
    </div>
  );

  return (
    <>
      <Head>
        <title>{property.title} - RentaTurista</title>
        <meta name="description" content={property.description?.slice(0, 160)} />
      </Head>

      <div style={{ maxWidth: 1200, margin: "0 auto", padding: "2rem clamp(1.5rem, 5vw, 4rem)" }}>
        {/* Back */}
        <Link href="/busqueda" style={{ display: "inline-flex", alignItems: "center", gap: "0.4rem", color: "#757575", textDecoration: "none", marginBottom: "1.5rem", fontFamily: "Poppins, sans-serif", fontSize: "0.9rem" }}>
          <ArrowLeft size={16} /> Volver a hospedajes
        </Link>

        {/* Title */}
        <div style={{ marginBottom: "1.5rem" }}>
          {property.type_name && (
            <span style={{ background: "rgba(255,107,53,0.1)", color: "#FF6B35", padding: "0.3rem 0.875rem", borderRadius: 50, fontSize: "0.85rem", fontWeight: 600, fontFamily: "Poppins, sans-serif" }}>
              {property.type_name}
            </span>
          )}
          <h1 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.75rem, 3vw, 2.5rem)", color: "#212121", marginTop: "0.75rem", marginBottom: "0.5rem" }}>
            {property.title}
          </h1>
          <div style={{ display: "flex", gap: "1.5rem", flexWrap: "wrap", alignItems: "center" }}>
            <span style={{ display: "flex", alignItems: "center", gap: "0.3rem", color: "#757575", fontSize: "0.95rem" }}>
              <MapPin size={15} /> {property.address}
            </span>
            {property.rating && (
              <span style={{ display: "flex", alignItems: "center", gap: "0.3rem", fontWeight: 600 }}>
                <Star size={15} style={{ fill: "#FFD700", color: "#FFD700" }} />
                {property.rating.toFixed(1)} ({property.reviews_count ?? 0} reseñas)
              </span>
            )}
          </div>
        </div>

        {/* Image Gallery */}
        {images.length > 0 && (
          <div style={{ position: "relative", borderRadius: 24, overflow: "hidden", height: 480, marginBottom: "2.5rem", background: "#F5F5F5" }}>
            <img src={images[imgIndex]?.url} alt={property.title} style={{ width: "100%", height: "100%", objectFit: "cover" }} />
            {images.length > 1 && (
              <>
                <button onClick={prevImg} style={{ position: "absolute", left: 16, top: "50%", transform: "translateY(-50%)", background: "rgba(255,255,255,0.9)", border: "none", borderRadius: "50%", width: 44, height: 44, display: "flex", alignItems: "center", justifyContent: "center", cursor: "pointer", boxShadow: "0 2px 8px rgba(0,0,0,0.15)" }}>
                  <ChevronLeft size={22} />
                </button>
                <button onClick={nextImg} style={{ position: "absolute", right: 16, top: "50%", transform: "translateY(-50%)", background: "rgba(255,255,255,0.9)", border: "none", borderRadius: "50%", width: 44, height: 44, display: "flex", alignItems: "center", justifyContent: "center", cursor: "pointer", boxShadow: "0 2px 8px rgba(0,0,0,0.15)" }}>
                  <ChevronRight size={22} />
                </button>
                <div style={{ position: "absolute", bottom: 16, left: "50%", transform: "translateX(-50%)", display: "flex", gap: "0.4rem" }}>
                  {images.map((_, i) => (
                    <button key={i} onClick={() => setImgIndex(i)} style={{ width: i === imgIndex ? 24 : 8, height: 8, borderRadius: 4, background: i === imgIndex ? "#FF6B35" : "rgba(255,255,255,0.7)", border: "none", cursor: "pointer", transition: "all 0.2s" }} />
                  ))}
                </div>
              </>
            )}
          </div>
        )}

        <div style={{ display: "grid", gridTemplateColumns: "1fr 360px", gap: "3rem", alignItems: "start" }}>
          {/* Left column */}
          <div>
            {/* Quick facts */}
            <div style={{ display: "flex", gap: "2rem", padding: "1.5rem", background: "#FAFAFA", borderRadius: 16, marginBottom: "2rem", flexWrap: "wrap" }}>
              {[
                { Icon: Bed, label: `${property.beds} ${property.beds === 1 ? "habitación" : "habitaciones"}` },
                { Icon: Bath, label: `${property.baths} ${property.baths === 1 ? "baño" : "baños"}` },
                { Icon: Users, label: `Hasta ${property.guests} huéspedes` },
              ].map(({ Icon, label }) => (
                <span key={label} style={{ display: "flex", alignItems: "center", gap: "0.5rem", fontFamily: "Poppins, sans-serif", fontWeight: 600, color: "#424242" }}>
                  <Icon size={20} style={{ color: "#FF6B35" }} /> {label}
                </span>
              ))}
            </div>

            {/* Description */}
            <section style={{ marginBottom: "2.5rem" }}>
              <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.25rem", color: "#212121", marginBottom: "1rem" }}>Descripción</h2>
              <p style={{ fontSize: "0.975rem", color: "#757575", lineHeight: 1.8, whiteSpace: "pre-line" }}>{property.description}</p>
            </section>

            {/* Amenities */}
            {property.amenities && property.amenities.length > 0 && (
              <section style={{ marginBottom: "2.5rem" }}>
                <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.25rem", color: "#212121", marginBottom: "1rem" }}>Servicios y comodidades</h2>
                <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(180px, 1fr))", gap: "0.75rem" }}>
                  {property.amenities.map(a => (
                    <div key={a.name} style={{ display: "flex", alignItems: "center", gap: "0.625rem", padding: "0.75rem 1rem", background: "#FAFAFA", borderRadius: 12, border: "1px solid #EEEEEE" }}>
                      <span style={{ color: "#FF6B35" }}>{AMENITY_ICONS[a.icon?.toLowerCase() ?? ""] ?? "✓"}</span>
                      <span style={{ fontSize: "0.9rem", fontWeight: 500, color: "#424242" }}>{a.name}</span>
                    </div>
                  ))}
                </div>
              </section>
            )}

            {/* Reviews */}
            {property.reviews && property.reviews.length > 0 && (
              <section>
                <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.25rem", color: "#212121", marginBottom: "1.5rem" }}>
                  Reseñas ({property.reviews.length})
                </h2>
                <div style={{ display: "flex", flexDirection: "column", gap: "1.25rem" }}>
                  {property.reviews.map(r => (
                    <div key={r.id} style={{ padding: "1.25rem", background: "#FAFAFA", borderRadius: 16, border: "1px solid #EEEEEE" }}>
                      <div style={{ display: "flex", justifyContent: "space-between", marginBottom: "0.75rem" }}>
                        <strong style={{ fontFamily: "Poppins, sans-serif", color: "#212121" }}>{r.author}</strong>
                        <div style={{ display: "flex", gap: "0.2rem" }}>
                          {[...Array(5)].map((_, i) => (
                            <Star key={i} size={14} style={{ fill: i < r.rating ? "#FFD700" : "#E0E0E0", color: i < r.rating ? "#FFD700" : "#E0E0E0" }} />
                          ))}
                        </div>
                      </div>
                      <p style={{ fontSize: "0.9rem", color: "#757575", lineHeight: 1.6 }}>{r.text}</p>
                    </div>
                  ))}
                </div>
              </section>
            )}
          </div>

          {/* Booking sidebar */}
          <div style={{ position: "sticky", top: 100 }}>
            <div style={{ background: "#fff", borderRadius: 24, padding: "2rem", boxShadow: "0 8px 40px rgba(0,0,0,0.12)", border: "1px solid #EEEEEE" }}>
              <div style={{ marginBottom: "1.5rem" }}>
                <span style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "1.75rem", color: "#FF6B35" }}>
                  ${property.price.toLocaleString("es-AR")}
                </span>
                <span style={{ fontSize: "0.9rem", color: "#757575" }}> / noche</span>
              </div>

              {property.rating && (
                <div style={{ display: "flex", alignItems: "center", gap: "0.4rem", marginBottom: "1.5rem", color: "#757575", fontSize: "0.9rem" }}>
                  <Star size={15} style={{ fill: "#FFD700", color: "#FFD700" }} />
                  <strong style={{ color: "#212121" }}>{property.rating.toFixed(1)}</strong>
                  · {property.reviews_count} reseñas
                </div>
              )}

              <a
                href={`https://wa.me/5493541123456?text=Hola! Me interesa la propiedad: ${encodeURIComponent(property.title)}`}
                target="_blank"
                rel="noopener noreferrer"
                style={{
                  display: "flex", alignItems: "center", justifyContent: "center", gap: "0.75rem",
                  background: "#25D366", color: "#fff", padding: "1rem",
                  borderRadius: 14, fontFamily: "Poppins, sans-serif", fontWeight: 700,
                  textDecoration: "none", fontSize: "1rem", marginBottom: "0.75rem",
                  boxShadow: "0 4px 16px rgba(37,211,102,0.3)",
                }}
              >
                Consultar por WhatsApp
              </a>

              <p style={{ fontSize: "0.82rem", color: "#757575", textAlign: "center" }}>
                Respuesta en menos de 1 hora
              </p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
