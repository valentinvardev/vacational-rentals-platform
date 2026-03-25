import Link from "next/link";
import { Home, Building2, Compass, Map, Search, Info, FileText, Shield, Mail, HelpCircle, PlusCircle, Settings, TrendingUp, ShieldCheck, MessageCircle, MapPin, Heart } from "lucide-react";

const FacebookIcon = () => <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>;
const InstagramIcon = () => <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>;
const TwitterIcon = () => <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>;

export default function Footer() {
  return (
    <footer style={{ background: "#212121", color: "rgba(255,255,255,0.8)", padding: "4rem 0 2rem" }}>
      <div className="container">
        <div style={{ display: "grid", gridTemplateColumns: "2fr 1fr 1fr 1fr", gap: "3rem", marginBottom: "3rem" }}>
          {/* Brand */}
          <div>
            <h3 style={{ fontFamily: "Poppins, sans-serif", fontSize: "1.75rem", fontWeight: 700, color: "#fff", marginBottom: "1rem" }}>
              RentaTurista
            </h3>
            <p style={{ fontSize: "0.9375rem", lineHeight: 1.7, marginBottom: "1.5rem", color: "rgba(255,255,255,0.7)" }}>
              Tu plataforma local de alquileres vacacionales en Villa Carlos Paz.
              Asistencia humana 24/7 y tecnología de vanguardia para una experiencia perfecta.
            </p>
            <div style={{ display: "flex", gap: "0.75rem", marginTop: "1.5rem" }}>
              {[
                { href: "https://facebook.com/rentaturista", label: "Facebook", Icon: FacebookIcon },
                { href: "https://instagram.com/rentaturista", label: "Instagram", Icon: InstagramIcon },
                { href: "https://twitter.com/rentaturista", label: "Twitter", Icon: TwitterIcon },
                { href: "https://wa.me/5493541123456", label: "WhatsApp", Icon: MessageCircle },
              ].map(({ href, label, Icon }) => (
                <a
                  key={label}
                  href={href}
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label={label}
                  style={{
                    width: 40, height: 40, background: "rgba(255,255,255,0.1)",
                    borderRadius: "50%", display: "flex", alignItems: "center",
                    justifyContent: "center", color: "#fff", transition: "all 0.2s",
                  }}
                >
                  <Icon size={18} />
                </a>
              ))}
            </div>
          </div>

          {/* Explorar */}
          <div>
            <h4 style={{ fontSize: "1rem", fontWeight: 700, color: "#fff", marginBottom: "1.25rem" }}>Explorar</h4>
            <ul style={{ listStyle: "none", padding: 0 }}>
              {[
                { href: "/", label: "Inicio", Icon: Home },
                { href: "/busqueda", label: "Hospedajes", Icon: Building2 },
                { href: "/actividades", label: "Actividades", Icon: Compass },
                { href: "/mapa", label: "Mapa interactivo", Icon: Map },
                { href: "/busqueda", label: "Búsqueda avanzada", Icon: Search },
              ].map(({ href, label, Icon }) => (
                <li key={label} style={{ marginBottom: "0.75rem" }}>
                  <Link href={href} style={{ color: "rgba(255,255,255,0.7)", textDecoration: "none", fontSize: "0.9375rem", display: "flex", alignItems: "center", gap: "0.5rem", transition: "all 0.2s" }}>
                    <Icon size={15} style={{ opacity: 0.6 }} />
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Información */}
          <div>
            <h4 style={{ fontSize: "1rem", fontWeight: 700, color: "#fff", marginBottom: "1.25rem" }}>Información</h4>
            <ul style={{ listStyle: "none", padding: 0 }}>
              {[
                { href: "#", label: "Acerca de nosotros", Icon: Info },
                { href: "/tyc", label: "Términos y condiciones", Icon: FileText },
                { href: "/privacidad", label: "Política de privacidad", Icon: Shield },
                { href: "#", label: "Contacto", Icon: Mail },
                { href: "#", label: "Centro de ayuda", Icon: HelpCircle },
              ].map(({ href, label, Icon }) => (
                <li key={label} style={{ marginBottom: "0.75rem" }}>
                  <Link href={href} style={{ color: "rgba(255,255,255,0.7)", textDecoration: "none", fontSize: "0.9375rem", display: "flex", alignItems: "center", gap: "0.5rem", transition: "all 0.2s" }}>
                    <Icon size={15} style={{ opacity: 0.6 }} />
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Para propietarios */}
          <div>
            <h4 style={{ fontSize: "1rem", fontWeight: 700, color: "#fff", marginBottom: "1.25rem" }}>Para propietarios</h4>
            <ul style={{ listStyle: "none", padding: 0 }}>
              {[
                { href: "#", label: "Publicar propiedad", Icon: PlusCircle },
                { href: "/admin/propiedades", label: "Gestión de propiedades", Icon: Settings },
                { href: "#", label: "Maximizar ingresos", Icon: TrendingUp },
                { href: "#", label: "Seguro para propietarios", Icon: ShieldCheck },
              ].map(({ href, label, Icon }) => (
                <li key={label} style={{ marginBottom: "0.75rem" }}>
                  <Link href={href} style={{ color: "rgba(255,255,255,0.7)", textDecoration: "none", fontSize: "0.9375rem", display: "flex", alignItems: "center", gap: "0.5rem", transition: "all 0.2s" }}>
                    <Icon size={15} style={{ opacity: 0.6 }} />
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div style={{ height: 1, background: "rgba(255,255,255,0.1)", margin: "2rem 0" }} />

        <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", flexWrap: "wrap", gap: "1rem" }}>
          <div>
            <p style={{ fontSize: "0.875rem", color: "rgba(255,255,255,0.6)", margin: 0 }}>
              © 2025 RentaTurista. Todos los derechos reservados.
            </p>
            <p style={{ display: "flex", alignItems: "center", gap: "0.375rem", marginTop: "0.25rem", fontSize: "0.875rem", color: "rgba(255,255,255,0.6)" }}>
              Hecho con <Heart size={13} style={{ color: "#EF4444", fill: "#EF4444" }} /> en Villa Carlos Paz
            </p>
          </div>
          <span style={{ display: "flex", alignItems: "center", gap: "0.375rem", fontSize: "0.875rem", color: "rgba(255,255,255,0.6)" }}>
            <MapPin size={13} />
            Villa Carlos Paz, Córdoba, Argentina
          </span>
        </div>
      </div>

      <style>{`
        @media (max-width: 1024px) {
          .footer-grid { grid-template-columns: 1fr 1fr !important; }
        }
        @media (max-width: 768px) {
          footer .container > div:first-child { grid-template-columns: 1fr !important; }
        }
      `}</style>
    </footer>
  );
}
