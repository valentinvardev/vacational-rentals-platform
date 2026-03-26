import Head from "next/head";
import Link from "next/link";
import { useRouter } from "next/router";
import { useEffect, useState } from "react";
import { Star, MapPin, Users, Bed, Bath, ArrowLeft, ChevronLeft, ChevronRight, Wifi, Tv, Car, Waves, Wind, Coffee, CheckCircle } from "lucide-react";

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
  type_name?: string;
  images?: { url: string; is_primary: boolean }[];
  amenities?: { name: string; icon?: string }[];
  reviews?: Review[];
}

const AMENITY_ICONS: Record<string, React.ReactNode> = {
  wifi: <Wifi size={16} />, tv: <Tv size={16} />, parking: <Car size={16} />,
  pool: <Waves size={16} />, ac: <Wind size={16} />, breakfast: <Coffee size={16} />,
};

const WA_NUMBER = "5493541123456";

export default function PropiedadPage() {
  const router = useRouter();
  const { id }  = router.query;
  const [property, setProperty] = useState<PropertyDetail | null>(null);
  const [loading, setLoading]   = useState(true);
  const [imgIdx, setImgIdx]     = useState(0);
  const [notFound, setNotFound] = useState(false);

  useEffect(() => {
    if (!id) return;
    fetch(`/api/properties/${id as string}`)
      .then(r => { if (!r.ok) { setNotFound(true); return null; } return r.json() as Promise<PropertyDetail>; })
      .then(d => { if (d) setProperty(d); })
      .catch(() => setNotFound(true))
      .finally(() => setLoading(false));
  }, [id]);

  const images = property?.images ?? [];
  const prev = () => setImgIdx(i => (i - 1 + images.length) % images.length);
  const next = () => setImgIdx(i => (i + 1) % images.length);

  if (loading) return (
    <div style={{ display: "flex", alignItems: "center", justifyContent: "center", minHeight: "60vh" }}>
      <div className="spinner" />
    </div>
  );

  if (notFound || !property) return (
    <div className="empty-state" style={{ paddingTop: "6rem" }}>
      <div className="empty-state-icon">🔍</div>
      <h3>Propiedad no encontrada</h3>
      <p><Link href="/busqueda" style={{ color: "var(--orange-primary)", fontWeight: 600 }}>Ver todos los hospedajes</Link></p>
    </div>
  );

  return (
    <>
      <Head>
        <title>{property.title} — RentaTurista</title>
        <meta name="description" content={property.description?.slice(0, 160)} />
      </Head>

      <div style={{ background: "var(--white)", paddingTop: "var(--header-height)" }}>
        <div className="property-page">

          {/* Back */}
          <Link href="/busqueda" className="back-btn">
            <ArrowLeft size={16} /> Volver a hospedajes
          </Link>

          {/* Title block */}
          {property.type_name && <span className="property-type-tag">{property.type_name}</span>}
          <h1 className="property-title">{property.title}</h1>
          <div className="property-meta">
            <span className="property-meta-item"><MapPin size={15} /> {property.address}</span>
            {property.rating != null && (
              <span className="property-meta-item">
                <Star size={15} style={{ fill: "#FFD700", color: "#FFD700" }} />
                <strong>{property.rating.toFixed(1)}</strong>
                &nbsp;· {property.reviews_count ?? 0} reseñas
              </span>
            )}
          </div>

          {/* Gallery */}
          {images.length > 0 && (
            <div className="gallery-wrapper">
              <img src={images[imgIdx]?.url} alt={property.title} />
              {images.length > 1 && (
                <>
                  <button className="gallery-nav prev" onClick={prev}><ChevronLeft size={22} /></button>
                  <button className="gallery-nav next" onClick={next}><ChevronRight size={22} /></button>
                  <div className="gallery-dots">
                    {images.map((_, i) => (
                      <button key={i} className={`gallery-dot${i === imgIdx ? " active" : ""}`} onClick={() => setImgIdx(i)} />
                    ))}
                  </div>
                </>
              )}
            </div>
          )}

          <div className="property-layout">
            {/* Left */}
            <div>
              {/* Quick facts */}
              <div className="quick-facts">
                <span className="quick-fact"><Bed size={18} /> {property.beds} {property.beds === 1 ? "habitación" : "habitaciones"}</span>
                <span className="quick-fact"><Bath size={18} /> {property.baths} {property.baths === 1 ? "baño" : "baños"}</span>
                <span className="quick-fact"><Users size={18} /> Hasta {property.guests} huéspedes</span>
              </div>

              {/* Description */}
              <div className="property-section">
                <h2 className="property-section-title">Descripción</h2>
                <p className="description-text">{property.description}</p>
              </div>

              {/* Amenities */}
              {property.amenities && property.amenities.length > 0 && (
                <div className="property-section">
                  <h2 className="property-section-title">Servicios y comodidades</h2>
                  <div className="amenities-grid">
                    {property.amenities.map(a => (
                      <div key={a.name} className="amenity-item">
                        {AMENITY_ICONS[a.icon?.toLowerCase() ?? ""] ?? <CheckCircle size={16} />}
                        {a.name}
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* Reviews */}
              {property.reviews && property.reviews.length > 0 && (
                <div className="property-section">
                  <h2 className="property-section-title">Reseñas ({property.reviews.length})</h2>
                  {property.reviews.map(r => (
                    <div key={r.id} className="review-item">
                      <div className="review-header">
                        <span className="review-author">{r.author}</span>
                        <div className="review-stars">
                          {[...Array(5)].map((_, i) => (
                            <Star key={i} size={14} style={{ fill: i < r.rating ? "#FFD700" : "var(--gray-300)", color: i < r.rating ? "#FFD700" : "var(--gray-300)" }} />
                          ))}
                        </div>
                      </div>
                      <p className="review-text">{r.text}</p>
                    </div>
                  ))}
                </div>
              )}
            </div>

            {/* Booking card */}
            <div className="booking-card">
              <div className="booking-price">
                ${property.price.toLocaleString("es-AR")}
                <span className="booking-price-unit"> / noche</span>
              </div>
              {property.rating != null && (
                <div className="booking-rating">
                  <Star size={14} style={{ fill: "#FFD700", color: "#FFD700" }} />
                  <strong style={{ color: "var(--gray-900)" }}>{property.rating.toFixed(1)}</strong>
                  &nbsp;· {property.reviews_count} reseñas
                </div>
              )}
              <a
                href={`https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(`Hola! Me interesa la propiedad: ${property.title}`)}`}
                target="_blank"
                rel="noopener noreferrer"
                className="booking-whatsapp-btn"
              >
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516" />
                </svg>
                Consultar por WhatsApp
              </a>
              <p className="booking-note">Respuesta en menos de 1 hora</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
