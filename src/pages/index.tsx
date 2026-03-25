import Head from "next/head";
import Link from "next/link";
import { useEffect, useState } from "react";
import { Search, Map, Star, Shield, Clock, Headphones, ArrowRight, ChevronRight } from "lucide-react";
import PropertyCard, { type Property } from "~/components/PropertyCard";

const FEATURES = [
  { Icon: Shield, title: "100% Verificado", desc: "Todas las propiedades son inspeccionadas y verificadas por nuestro equipo." },
  { Icon: Clock, title: "Disponibilidad 24/7", desc: "Asistencia humana disponible las 24 horas, los 7 días de la semana." },
  { Icon: Headphones, title: "Atención personalizada", desc: "Te acompañamos en cada paso, desde la búsqueda hasta el check-out." },
  { Icon: Star, title: "Las mejores reseñas", desc: "Miles de huéspedes satisfechos avalan la calidad de nuestros hospedajes." },
];

export default function HomePage() {
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");

  useEffect(() => {
    fetch("/api/properties?limit=6")
      .then(r => r.json())
      .then((data: { data?: Property[] } | Property[]) => {
        const arr = Array.isArray(data) ? data : ((data as { data?: Property[] }).data ?? []);
        setProperties(arr);
      })
      .catch(() => setProperties([]))
      .finally(() => setLoading(false));
  }, []);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    window.location.href = `/busqueda?q=${encodeURIComponent(search)}`;
  };

  return (
    <>
      <Head>
        <title>RentaTurista - Alquileres Vacacionales en Villa Carlos Paz</title>
        <meta name="description" content="Encuentra el mejor alojamiento en Villa Carlos Paz. Alquileres vacacionales con atención 24/7 y asistencia personalizada." />
        <meta name="theme-color" content="#FF6B35" />
      </Head>

      {/* Hero */}
      <section style={{
        minHeight: "calc(100vh - 80px)",
        background: "linear-gradient(135deg, #FFF5F2 0%, #FFFFFF 50%, #FFF8F5 100%)",
        display: "flex",
        alignItems: "center",
        padding: "4rem clamp(1.5rem, 5vw, 4rem)",
        position: "relative",
        overflow: "hidden",
      }}>
        <div style={{ position: "absolute", top: -100, right: -100, width: 500, height: 500, background: "radial-gradient(circle, rgba(255,107,53,0.08) 0%, transparent 70%)", borderRadius: "50%", pointerEvents: "none" }} />
        <div style={{ position: "absolute", bottom: -50, left: -50, width: 300, height: 300, background: "radial-gradient(circle, rgba(255,107,53,0.05) 0%, transparent 70%)", borderRadius: "50%", pointerEvents: "none" }} />

        <div className="hero-grid" style={{ maxWidth: 1400, margin: "0 auto", width: "100%", display: "grid", gridTemplateColumns: "1fr 1fr", gap: "4rem", alignItems: "center" }}>
          <div>
            <div style={{
              display: "inline-flex", alignItems: "center", gap: "0.5rem",
              background: "rgba(255,107,53,0.1)", color: "#FF6B35",
              padding: "0.4rem 1rem", borderRadius: 50, fontSize: "0.85rem",
              fontWeight: 600, marginBottom: "1.5rem", fontFamily: "Poppins, sans-serif",
            }}>
              <Star size={14} style={{ fill: "#FF6B35" }} />
              +500 huéspedes satisfechos
            </div>

            <h1 style={{
              fontFamily: "Poppins, sans-serif", fontWeight: 800,
              fontSize: "clamp(2.5rem, 5vw, 4rem)", lineHeight: 1.1,
              color: "#212121", marginBottom: "1.5rem",
            }}>
              Tu hospedaje ideal en{" "}
              <span style={{ color: "#FF6B35" }}>Villa Carlos Paz</span>
            </h1>

            <p style={{ fontSize: "1.1rem", color: "#757575", lineHeight: 1.7, marginBottom: "2.5rem", maxWidth: 480 }}>
              Descubrí los mejores alquileres vacacionales con asistencia 24/7 y tecnología de vanguardia para una experiencia perfecta.
            </p>

            <form onSubmit={handleSearch} style={{
              display: "flex", gap: "0.75rem", marginBottom: "2rem",
              background: "#fff", borderRadius: 60, padding: "0.5rem 0.5rem 0.5rem 1.25rem",
              boxShadow: "0 8px 32px rgba(0,0,0,0.12)", border: "1px solid #EEEEEE",
              maxWidth: 500,
            }}>
              <Search size={20} style={{ color: "#757575", flexShrink: 0, alignSelf: "center" }} />
              <input
                type="text"
                placeholder="¿Qué tipo de hospedaje buscás?"
                value={search}
                onChange={e => setSearch(e.target.value)}
                style={{
                  flex: 1, border: "none", outline: "none", fontSize: "0.95rem",
                  fontFamily: "Poppins, sans-serif", color: "#212121", background: "transparent",
                }}
              />
              <button type="submit" style={{
                background: "#FF6B35", color: "#fff", border: "none",
                padding: "0.75rem 1.5rem", borderRadius: 50, fontFamily: "Poppins, sans-serif",
                fontWeight: 600, fontSize: "0.9rem", cursor: "pointer",
                whiteSpace: "nowrap",
              }}>
                Buscar
              </button>
            </form>

            <div style={{ display: "flex", gap: "1rem", flexWrap: "wrap" }}>
              <Link href="/busqueda" style={{
                display: "inline-flex", alignItems: "center", gap: "0.5rem",
                background: "#FF6B35", color: "#fff", padding: "0.875rem 2rem",
                borderRadius: 50, fontFamily: "Poppins, sans-serif", fontWeight: 700,
                textDecoration: "none", boxShadow: "0 8px 32px rgba(255,107,53,0.35)",
              }}>
                Ver todos los hospedajes <ArrowRight size={18} />
              </Link>
              <Link href="/mapa" style={{
                display: "inline-flex", alignItems: "center", gap: "0.5rem",
                background: "transparent", color: "#212121", padding: "0.875rem 2rem",
                borderRadius: 50, fontFamily: "Poppins, sans-serif", fontWeight: 600,
                textDecoration: "none", border: "2px solid #E0E0E0",
              }}>
                <Map size={18} /> Ver en el mapa
              </Link>
            </div>
          </div>

          <div className="hero-cards" style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "1rem" }}>
            {["🏡 Cabañas de montaña", "🏊 Con piscina", "🌊 Cerca del lago", "🏙️ Centro de la ciudad"].map((item, i) => (
              <div key={i} style={{
                background: "#fff", borderRadius: 20, padding: "1.5rem",
                boxShadow: "0 4px 24px rgba(0,0,0,0.08)", border: "1px solid #EEEEEE",
                transform: i % 2 === 1 ? "translateY(1.5rem)" : undefined,
                fontFamily: "Poppins, sans-serif", fontSize: "0.95rem", fontWeight: 600, color: "#212121",
              }}>
                {item}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features */}
      <section style={{ padding: "5rem clamp(1.5rem, 5vw, 4rem)", background: "#FAFAFA" }}>
        <div style={{ maxWidth: 1400, margin: "0 auto" }}>
          <div style={{ textAlign: "center", marginBottom: "3rem" }}>
            <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.75rem, 3vw, 2.25rem)", color: "#212121", marginBottom: "0.75rem" }}>
              ¿Por qué elegir RentaTurista?
            </h2>
            <p style={{ fontSize: "1.05rem", color: "#757575", maxWidth: 500, margin: "0 auto" }}>
              Somos la plataforma local con mayor confianza en Villa Carlos Paz
            </p>
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit, minmax(240px, 1fr))", gap: "1.5rem" }}>
            {FEATURES.map(({ Icon, title, desc }) => (
              <div key={title} style={{
                background: "#fff", borderRadius: 20, padding: "2rem",
                boxShadow: "0 4px 24px rgba(0,0,0,0.06)", border: "1px solid #EEEEEE",
              }}>
                <div style={{ width: 56, height: 56, background: "rgba(255,107,53,0.1)", borderRadius: 16, display: "flex", alignItems: "center", justifyContent: "center", marginBottom: "1rem" }}>
                  <Icon size={26} style={{ color: "#FF6B35" }} />
                </div>
                <h3 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1rem", color: "#212121", marginBottom: "0.5rem" }}>{title}</h3>
                <p style={{ fontSize: "0.9rem", color: "#757575", lineHeight: 1.6 }}>{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Properties */}
      <section id="hospedajes" style={{ padding: "5rem clamp(1.5rem, 5vw, 4rem)" }}>
        <div style={{ maxWidth: 1400, margin: "0 auto" }}>
          <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-end", marginBottom: "2.5rem", flexWrap: "wrap", gap: "1rem" }}>
            <div>
              <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.75rem, 3vw, 2.25rem)", color: "#212121", marginBottom: "0.5rem" }}>
                Hospedajes destacados
              </h2>
              <p style={{ fontSize: "1.05rem", color: "#757575" }}>Los más elegidos por nuestros huéspedes</p>
            </div>
            <Link href="/busqueda" style={{ display: "inline-flex", alignItems: "center", gap: "0.4rem", color: "#FF6B35", fontFamily: "Poppins, sans-serif", fontWeight: 600, textDecoration: "none" }}>
              Ver todos <ChevronRight size={18} />
            </Link>
          </div>

          {loading ? (
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(300px, 1fr))", gap: "1.5rem" }}>
              {[...Array(6)].map((_, i) => (
                <div key={i} style={{ height: 380, background: "#F5F5F5", borderRadius: 20 }} />
              ))}
            </div>
          ) : properties.length > 0 ? (
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(300px, 1fr))", gap: "1.5rem" }}>
              {properties.map(p => <PropertyCard key={p.id} property={p} />)}
            </div>
          ) : (
            <div style={{ textAlign: "center", padding: "4rem", color: "#757575" }}>
              <p style={{ fontSize: "1.1rem", marginBottom: "1rem" }}>No hay propiedades disponibles aún.</p>
            </div>
          )}
        </div>
      </section>

      {/* CTA */}
      <section style={{
        padding: "5rem clamp(1.5rem, 5vw, 4rem)",
        background: "linear-gradient(135deg, #FF6B35 0%, #E55527 100%)",
        color: "#fff", textAlign: "center",
      }}>
        <div style={{ maxWidth: 700, margin: "0 auto" }}>
          <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.75rem, 3.5vw, 2.5rem)", marginBottom: "1rem" }}>
            ¿Listo para tu próxima escapada?
          </h2>
          <p style={{ fontSize: "1.1rem", opacity: 0.9, marginBottom: "2rem" }}>
            Contactanos y te ayudamos a encontrar el hospedaje perfecto para vos.
          </p>
          <a
            href="https://wa.me/5493541123456"
            target="_blank"
            rel="noopener noreferrer"
            style={{
              display: "inline-flex", alignItems: "center", gap: "0.75rem",
              background: "#fff", color: "#FF6B35", padding: "1rem 2.5rem",
              borderRadius: 50, fontFamily: "Poppins, sans-serif", fontWeight: 700,
              textDecoration: "none", boxShadow: "0 8px 32px rgba(0,0,0,0.2)",
            }}
          >
            Contactar por WhatsApp
          </a>
        </div>
      </section>

      <style>{`
        @media (max-width: 768px) {
          .hero-grid { grid-template-columns: 1fr !important; }
          .hero-cards { display: none !important; }
        }
      `}</style>
    </>
  );
}
