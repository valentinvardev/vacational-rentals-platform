import type { ReactNode } from "react";
import Link from "next/link";
import { useRouter } from "next/router";
import {
  Building2, Plus, Calendar, ChevronLeft, LayoutDashboard, ExternalLink,
} from "lucide-react";

const NAV = [
  { section: "Contenido", items: [
    { href: "/admin/propiedades", label: "Propiedades", Icon: Building2 },
    { href: "/admin/propiedades/nueva", label: "Nueva Propiedad", Icon: Plus },
  ]},
  { section: "Herramientas", items: [
    { href: "/admin/dashboard", label: "Dashboard", Icon: LayoutDashboard },
  ]},
];

export default function AdminLayout({ children, title }: { children: ReactNode; title?: string }) {
  const router = useRouter();

  return (
    <div style={{ display: "flex", minHeight: "100vh", background: "linear-gradient(135deg,#FAFAFA 0%,#F5F5F5 100%)", fontFamily: "var(--font-body)" }}>

      {/* Sidebar */}
      <aside style={{
        position: "fixed", top: 0, left: 0, width: 260, height: "100vh",
        background: "#fff", borderRight: "2px solid rgba(101,67,33,0.08)",
        zIndex: 100, overflowY: "auto", display: "flex", flexDirection: "column",
      }}>
        {/* Logo */}
        <div style={{ padding: "1.5rem", borderBottom: "2px solid rgba(101,67,33,0.08)" }}>
          <Link href="/admin/propiedades" style={{ display: "flex", alignItems: "center", gap: "0.75rem", textDecoration: "none" }}>
            <div style={{ width: 40, height: 40, background: "linear-gradient(135deg,#FF6B35,#E55527)", borderRadius: 12, display: "flex", alignItems: "center", justifyContent: "center", color: "#fff", flexShrink: 0 }}>
              <Building2 size={20} />
            </div>
            <div>
              <div style={{ fontFamily: "var(--font-primary)", fontWeight: 800, fontSize: "1.1rem", color: "#FF6B35" }}>RentaTurista</div>
              <div style={{ fontSize: "0.75rem", color: "#9E9E9E", fontWeight: 600 }}>Panel Admin</div>
            </div>
          </Link>
        </div>

        {/* Nav */}
        <nav style={{ padding: "1rem 0", flex: 1 }}>
          {NAV.map(({ section, items }) => (
            <div key={section} style={{ marginBottom: "1.5rem" }}>
              <div style={{ padding: "0.375rem 1.25rem", fontSize: "0.7rem", fontWeight: 700, textTransform: "uppercase", letterSpacing: "0.1em", color: "#BDBDBD" }}>
                {section}
              </div>
              {items.map(({ href, label, Icon }) => {
                const active = router.pathname === href || router.pathname.startsWith(href + "/");
                return (
                  <Link key={href} href={href} style={{
                    display: "flex", alignItems: "center", gap: "0.75rem",
                    padding: "0.8rem 1.25rem", textDecoration: "none",
                    color: active ? "#FF6B35" : "#616161",
                    fontWeight: active ? 700 : 500,
                    fontSize: "0.9rem",
                    background: active ? "rgba(255,107,53,0.08)" : "transparent",
                    borderLeft: `3px solid ${active ? "#FF6B35" : "transparent"}`,
                    transition: "all 0.2s",
                  }}>
                    <Icon size={18} />
                    {label}
                  </Link>
                );
              })}
            </div>
          ))}
        </nav>

        {/* Footer link */}
        <div style={{ padding: "1rem 1.25rem", borderTop: "2px solid rgba(101,67,33,0.08)" }}>
          <Link href="/" style={{ display: "flex", alignItems: "center", gap: "0.5rem", color: "#9E9E9E", textDecoration: "none", fontSize: "0.85rem", fontWeight: 600 }}>
            <ExternalLink size={15} /> Ver sitio público
          </Link>
        </div>
      </aside>

      {/* Main */}
      <div style={{ marginLeft: 260, flex: 1, display: "flex", flexDirection: "column" }}>
        {/* Top bar */}
        <header style={{
          position: "sticky", top: 0, zIndex: 50,
          background: "rgba(255,255,255,0.95)", backdropFilter: "blur(12px)",
          borderBottom: "2px solid rgba(101,67,33,0.08)",
          padding: "0 2rem", height: 64,
          display: "flex", alignItems: "center", justifyContent: "space-between",
        }}>
          <div style={{ display: "flex", alignItems: "center", gap: "0.75rem" }}>
            <button onClick={() => router.back()} style={{ background: "rgba(255,107,53,0.1)", border: "2px solid #FF6B35", borderRadius: 10, width: 36, height: 36, display: "flex", alignItems: "center", justifyContent: "center", color: "#FF6B35", cursor: "pointer" }}>
              <ChevronLeft size={18} />
            </button>
            {title && (
              <h1 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.25rem", color: "#212121", margin: 0 }}>
                {title}
              </h1>
            )}
          </div>
          <Link href="/admin/propiedades/nueva" style={{
            display: "inline-flex", alignItems: "center", gap: "0.4rem",
            background: "linear-gradient(135deg,#FF6B35,#E55527)", color: "#fff",
            padding: "0.5rem 1.1rem", borderRadius: 10, fontWeight: 600, fontSize: "0.875rem",
            textDecoration: "none",
          }}>
            <Plus size={16} /> Nueva
          </Link>
        </header>

        <main style={{ padding: "2rem", flex: 1 }}>
          {children}
        </main>
      </div>
    </div>
  );
}

// Helper: use in page files to skip public layout
export function withAdminLayout(title?: string) {
  return (page: ReactNode) => <AdminLayout title={title}>{page}</AdminLayout>;
}
