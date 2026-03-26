import Head from "next/head";
import Link from "next/link";
import { useEffect, useState, useRef } from "react";
import { Search, Map, Star, Shield, Clock, Headphones, ArrowRight, ChevronRight } from "lucide-react";
import PropertyCard, { type Property } from "~/components/PropertyCard";

const SLIDES = [
  "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=1600&fit=crop",
  "https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&h=1600&fit=crop",
  "https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&h=1600&fit=crop",
  "https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=1200&h=1600&fit=crop",
];

const FEATURES = [
  { Icon: Shield,      title: "100% Verificado",        desc: "Todas las propiedades son inspeccionadas y verificadas por nuestro equipo." },
  { Icon: Clock,       title: "Disponibilidad 24/7",    desc: "Asistencia humana disponible las 24 horas, los 7 días de la semana." },
  { Icon: Headphones,  title: "Atención personalizada", desc: "Te acompañamos desde la búsqueda hasta el check-out." },
  { Icon: Star,        title: "Las mejores reseñas",    desc: "Miles de huéspedes satisfechos avalan la calidad de nuestros hospedajes." },
];

export default function HomePage() {
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading]       = useState(true);
  const [search, setSearch]         = useState("");
  const [slide, setSlide]           = useState(0);
  const intervalRef = useRef<ReturnType<typeof setInterval> | undefined>(undefined);

  // hero slider
  useEffect(() => {
    intervalRef.current = setInterval(() => setSlide(s => (s + 1) % SLIDES.length), 5000);
    return () => clearInterval(intervalRef.current);
  }, []);

  // properties
  useEffect(() => {
    fetch("/api/properties?limit=6")
      .then(r => r.json())
      .then((d: { data?: Property[] } | Property[]) => {
        setProperties(Array.isArray(d) ? d : ((d as { data?: Property[] }).data ?? []));
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
        <title>RentaTurista — Alquileres Vacacionales en Villa Carlos Paz</title>
        <meta name="description" content="Encontrá el mejor alojamiento en Villa Carlos Paz. Alquileres vacacionales con atención 24/7." />
        <meta name="theme-color" content="#FF6B35" />
      </Head>

      {/* ── Hero ─────────────────────────────── */}
      <section className="hero">
        {/* Left — content */}
        <div className="hero-content">
          <div className="hero-inner">
            <span className="hero-badge">
              <Star size={14} style={{ fill: "var(--orange-primary)" }} />
              +500 huéspedes satisfechos
            </span>

            <h1 className="hero-title">
              Tu hospedaje ideal<br />
              en <span style={{ color: "var(--orange-primary)" }}>Villa Carlos Paz</span>
            </h1>

            <p className="hero-subtitle">
              Descubrí los mejores alquileres vacacionales con asistencia 24/7
              y tecnología de vanguardia para una experiencia perfecta.
            </p>

            <form className="hero-search" onSubmit={handleSearch}>
              <Search size={18} style={{ color: "var(--gray-400)", marginRight: ".25rem", flexShrink: 0 }} />
              <input
                type="text"
                placeholder="¿Qué tipo de hospedaje buscás?"
                value={search}
                onChange={e => setSearch(e.target.value)}
              />
              <button type="submit">Buscar</button>
            </form>

            <div className="hero-cta-group">
              <Link href="/busqueda" className="btn btn-primary btn-lg">
                Ver hospedajes <ArrowRight size={18} />
              </Link>
              <Link href="/mapa" className="btn btn-outline btn-lg">
                <Map size={18} /> Ver en el mapa
              </Link>
            </div>
          </div>
        </div>

        {/* Right — image slider */}
        <div className="hero-slider-container">
          {SLIDES.map((src, i) => (
            <div
              key={i}
              className={`hero-slide${slide === i ? " active" : ""}`}
              style={{ backgroundImage: `url(${src})` }}
            />
          ))}
          <div className="hero-slider-dots">
            {SLIDES.map((_, i) => (
              <button
                key={i}
                className={`hero-dot${slide === i ? " active" : ""}`}
                onClick={() => { setSlide(i); clearInterval(intervalRef.current); }}
              />
            ))}
          </div>
        </div>
      </section>

      {/* ── Features ─────────────────────────── */}
      <section style={{ padding: "6rem 0", background: "var(--gray-50)" }}>
        <div className="container">
          <div style={{ textAlign: "center", marginBottom: "3rem" }}>
            <span className="section-label">Nuestras ventajas</span>
            <h2 className="section-title">¿Por qué elegir RentaTurista?</h2>
            <p className="section-description" style={{ margin: "0 auto" }}>
              Somos la plataforma local con mayor confianza en Villa Carlos Paz
            </p>
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit,minmax(240px,1fr))", gap: "1.5rem" }}>
            {FEATURES.map(({ Icon, title, desc }) => (
              <div key={title} className="feature-card">
                <div className="feature-icon"><Icon size={26} /></div>
                <p className="feature-title">{title}</p>
                <p className="feature-desc">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── Properties ───────────────────────── */}
      <section id="hospedajes" style={{ padding: "6rem 0", background: "var(--white)" }}>
        <div className="container">
          <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-end", marginBottom: "3rem", flexWrap: "wrap", gap: "1rem" }}>
            <div>
              <span className="section-label">Hospedajes</span>
              <h2 className="section-title" style={{ marginBottom: ".5rem" }}>Destacados</h2>
              <p className="section-description">Los más elegidos por nuestros huéspedes</p>
            </div>
            <Link href="/busqueda" style={{ display: "inline-flex", alignItems: "center", gap: ".375rem", color: "var(--orange-primary)", fontFamily: "var(--font-primary)", fontWeight: 600, fontSize: ".9375rem" }}>
              Ver todos <ChevronRight size={17} />
            </Link>
          </div>

          {loading ? (
            <div className="cards-grid">
              {[...Array(6)].map((_, i) => <div key={i} className="skeleton" style={{ height: 380 }} />)}
            </div>
          ) : properties.length > 0 ? (
            <div className="cards-grid">
              {properties.map(p => <PropertyCard key={p.id} property={p} />)}
            </div>
          ) : (
            <div className="empty-state">
              <div className="empty-state-icon">🏠</div>
              <h3>No hay propiedades aún</h3>
              <p>Pronto aparecerán los hospedajes disponibles.</p>
            </div>
          )}
        </div>
      </section>

      {/* ── CTA ──────────────────────────────── */}
      <section className="cta-banner">
        <div className="container">
          <h2>¿Listo para tu próxima escapada?</h2>
          <p>Contactanos y te ayudamos a encontrar el hospedaje perfecto para vos.</p>
          <a href="https://wa.me/5493541123456" target="_blank" rel="noopener noreferrer" className="btn btn-lg" style={{ background: "var(--white)", color: "var(--orange-primary)", display: "inline-flex", alignItems: "center", gap: ".75rem" }}>
            Contactar por WhatsApp
          </a>
        </div>
      </section>
    </>
  );
}
