import { useState, useEffect } from "react";
import Link from "next/link";
import { useRouter } from "next/router";
import { Map, Home, Search, Menu, X, Building, SlidersHorizontal, Heart, Calendar } from "lucide-react";

const WA_NUMBER = "5493541123456";

const WhatsAppIcon = () => (
  <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516" />
  </svg>
);

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [hidden, setHidden] = useState(false);
  const router = useRouter();

  useEffect(() => {
    let lastY = 0;
    const onScroll = () => {
      const y = window.scrollY;
      setHidden(y > lastY && y > 100);
      lastY = y <= 0 ? 0 : y;
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    if (menuOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
    return () => { document.body.style.overflow = ""; };
  }, [menuOpen]);

  const close = () => setMenuOpen(false);

  const navLinks = [
    { href: "/mapa", label: "Mapa", Icon: Map },
    { href: "/busqueda", label: "Hospedajes", Icon: Home },
    { href: "/busqueda", label: "Buscar", Icon: Search },
  ];

  return (
    <>
      <header
        style={{
          position: "fixed",
          top: 0,
          width: "100%",
          background: "#fff",
          borderBottom: "2px solid rgba(101,67,33,0.1)",
          boxShadow: "0 2px 16px rgba(0,0,0,0.1)",
          zIndex: 1000,
          transition: "transform 0.3s cubic-bezier(0.4,0,0.2,1)",
          transform: hidden ? "translateY(-100%)" : "translateY(0)",
        }}
      >
        <nav
          style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "space-between",
            height: 80,
            padding: "0 clamp(1.5rem, 5vw, 4rem)",
            maxWidth: 1400,
            margin: "0 auto",
          }}
        >
          <Link href="/" style={{ display: "flex", alignItems: "center", textDecoration: "none" }}>
            <span style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "1.5rem", color: "#FF6B35", letterSpacing: "-0.02em" }}>
              Renta<span style={{ color: "#212121" }}>Turista</span>
            </span>
          </Link>

          {/* Desktop nav */}
          <ul style={{ display: "flex", alignItems: "center", gap: "2rem", listStyle: "none", margin: 0, padding: 0 }} className="desktop-nav">
            {navLinks.map(({ href, label, Icon }) => (
              <li key={label}>
                <Link
                  href={href}
                  style={{
                    display: "flex",
                    alignItems: "center",
                    gap: "0.4rem",
                    fontFamily: "Poppins, sans-serif",
                    fontWeight: 500,
                    fontSize: "0.95rem",
                    color: router.pathname === href ? "#FF6B35" : "#212121",
                    textDecoration: "none",
                    padding: "0.5rem 0.75rem",
                    borderRadius: 12,
                    transition: "all 0.2s",
                  }}
                >
                  <Icon size={17} strokeWidth={2} />
                  {label}
                </Link>
              </li>
            ))}
            <li>
              <a
                href={`https://wa.me/${WA_NUMBER}`}
                target="_blank"
                rel="noopener noreferrer"
                style={{
                  display: "inline-flex",
                  alignItems: "center",
                  gap: "0.4rem",
                  fontFamily: "Poppins, sans-serif",
                  fontWeight: 600,
                  background: "#25D366",
                  color: "#fff",
                  padding: "0.6rem 1.25rem",
                  borderRadius: 50,
                  textDecoration: "none",
                  boxShadow: "0 8px 32px rgba(37,211,102,0.3)",
                  transition: "all 0.2s",
                }}
              >
                <WhatsAppIcon />
                Contáctanos
              </a>
            </li>
          </ul>

          {/* Mobile hamburger */}
          <button
            onClick={() => setMenuOpen(true)}
            aria-label="Abrir menú"
            className="mobile-menu-btn"
            style={{
              display: "none",
              background: "none",
              border: "none",
              cursor: "pointer",
              padding: "0.5rem",
              borderRadius: 12,
              color: "#757575",
            }}
          >
            <Menu size={24} />
          </button>
        </nav>
      </header>

      {/* Mobile overlay */}
      {menuOpen && (
        <div
          onClick={close}
          style={{
            position: "fixed", inset: 0, background: "rgba(0,0,0,0.5)",
            zIndex: 1000, cursor: "pointer",
          }}
        />
      )}

      {/* Mobile sidebar */}
      <nav
        style={{
          position: "fixed",
          top: 0,
          right: menuOpen ? 0 : -350,
          width: 350,
          height: "100vh",
          background: "linear-gradient(180deg,#FF6B35 0%,#E55527 100%)",
          zIndex: 1001,
          transition: "right 0.3s cubic-bezier(0.4,0,0.2,1)",
          overflowY: "auto",
          boxShadow: "-4px 0 24px rgba(0,0,0,0.2)",
        }}
      >
        <div style={{ padding: "1.5rem", borderBottom: "2px solid rgba(255,255,255,0.2)", position: "relative" }}>
          <button
            onClick={close}
            style={{ position: "absolute", top: "1.25rem", right: "1.25rem", background: "rgba(255,255,255,0.2)", border: "none", borderRadius: "50%", width: 40, height: 40, display: "flex", alignItems: "center", justifyContent: "center", color: "#fff", cursor: "pointer" }}
          >
            <X size={20} />
          </button>
          <span style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "1.5rem", color: "#fff", filter: "brightness(0) invert(1)" }}>
            RentaTurista
          </span>
          <p style={{ color: "rgba(255,255,255,0.8)", fontSize: "0.9rem", marginTop: "0.5rem" }}>
            Tu hospedaje ideal en Villa Carlos Paz
          </p>
        </div>

        <div style={{ padding: "1.5rem" }}>
          <p style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "0.85rem", color: "rgba(255,255,255,0.7)", textTransform: "uppercase", letterSpacing: "0.05em", marginBottom: "1rem" }}>
            Navegación
          </p>
          {[
            { href: "/", label: "Inicio", Icon: Home },
            { href: "/mapa", label: "Mapa Interactivo", Icon: Map },
            { href: "/busqueda", label: "Buscar Hospedajes", Icon: Search },
            { href: "/busqueda", label: "Todos los Hospedajes", Icon: Building },
          ].map(({ href, label, Icon }) => (
            <Link
              key={label}
              href={href}
              onClick={close}
              style={{
                display: "flex", alignItems: "center", gap: "1rem",
                padding: "0.875rem 1rem", background: "rgba(255,255,255,0.1)",
                borderRadius: 16, textDecoration: "none", color: "#fff",
                fontWeight: 600, fontFamily: "Poppins, sans-serif",
                marginBottom: "0.6rem", border: "2px solid transparent",
                transition: "all 0.2s",
              }}
            >
              <Icon size={22} />
              {label}
            </Link>
          ))}

          <p style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "0.85rem", color: "rgba(255,255,255,0.7)", textTransform: "uppercase", letterSpacing: "0.05em", margin: "1.5rem 0 1rem" }}>
            Herramientas
          </p>
          {[
            { href: "/busqueda", label: "Filtros Avanzados", Icon: SlidersHorizontal },
            { href: "#", label: "Favoritos", Icon: Heart },
            { href: "#", label: "Disponibilidad", Icon: Calendar },
          ].map(({ href, label, Icon }) => (
            <Link
              key={label}
              href={href}
              onClick={close}
              style={{
                display: "flex", alignItems: "center", gap: "1rem",
                padding: "0.875rem 1rem", background: "rgba(255,255,255,0.1)",
                borderRadius: 16, textDecoration: "none", color: "#fff",
                fontWeight: 600, fontFamily: "Poppins, sans-serif",
                marginBottom: "0.6rem", border: "2px solid transparent",
              }}
            >
              <Icon size={22} />
              {label}
            </Link>
          ))}

          <a
            href={`https://wa.me/${WA_NUMBER}`}
            target="_blank"
            rel="noopener noreferrer"
            style={{
              display: "flex", alignItems: "center", gap: "1rem",
              padding: "0.875rem 1rem", background: "#25D366",
              borderRadius: 16, textDecoration: "none", color: "#fff",
              fontWeight: 700, fontFamily: "Poppins, sans-serif",
              marginTop: "1.5rem", boxShadow: "0 4px 16px rgba(37,211,102,0.3)",
            }}
          >
            <WhatsAppIcon />
            Contáctanos por WhatsApp
          </a>
        </div>
      </nav>

      <style>{`
        @media (max-width: 768px) {
          .desktop-nav { display: none !important; }
          .mobile-menu-btn { display: block !important; }
        }
      `}</style>
    </>
  );
}
