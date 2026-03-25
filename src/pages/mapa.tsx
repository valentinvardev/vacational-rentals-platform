import Head from "next/head";
import dynamic from "next/dynamic";
import { useEffect, useState } from "react";
import { ChevronLeft, ChevronRight, MapPin } from "lucide-react";
import Link from "next/link";
import type { Property } from "~/components/PropertyCard";

// Dynamic import to avoid SSR issues with Leaflet
const MapView = dynamic(() => import("~/components/MapView"), { ssr: false, loading: () => (
  <div style={{ height: "100%", display: "flex", alignItems: "center", justifyContent: "center", background: "#F5F5F5" }}>
    <div style={{ width: 40, height: 40, border: "3px solid #EEEEEE", borderTopColor: "#FF6B35", borderRadius: "50%", animation: "spin 0.8s linear infinite" }} />
    <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
  </div>
) });

export default function MapaPage() {
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading] = useState(true);
  const [sidebarOpen, setSidebarOpen] = useState(true);

  useEffect(() => {
    fetch("/api/properties?limit=100")
      .then(r => r.json())
      .then((data: { data?: Property[] } | Property[]) => {
        const arr = Array.isArray(data) ? data : ((data as { data?: Property[] }).data ?? []);
        setProperties(arr);
      })
      .catch(() => setProperties([]))
      .finally(() => setLoading(false));
  }, []);

  return (
    <>
      <Head>
        <title>Mapa de Hospedajes - Villa Carlos Paz | RentaTurista</title>
        <meta name="description" content="Mapa interactivo de hospedajes y actividades en Villa Carlos Paz." />
      </Head>

      <div style={{ display: "flex", height: "calc(100vh - 80px)", overflow: "hidden" }}>
        {/* Sidebar */}
        <div style={{
          width: sidebarOpen ? 360 : 0,
          minWidth: sidebarOpen ? 360 : 0,
          overflow: "hidden",
          transition: "all 0.3s cubic-bezier(0.4,0,0.2,1)",
          background: "#fff",
          borderRight: "1px solid #EEEEEE",
          display: "flex",
          flexDirection: "column",
        }}>
          <div style={{ padding: "1.25rem", borderBottom: "1px solid #EEEEEE", flexShrink: 0 }}>
            <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.1rem", color: "#212121" }}>
              {properties.length} hospedajes en el mapa
            </h2>
          </div>
          <div style={{ overflowY: "auto", flex: 1, padding: "0.75rem" }}>
            {loading ? (
              [...Array(6)].map((_, i) => (
                <div key={i} style={{ height: 80, background: "#F5F5F5", borderRadius: 12, marginBottom: "0.75rem" }} />
              ))
            ) : (
              properties.map(p => (
                <Link
                  key={p.id}
                  href={`/propiedad/${p.id}`}
                  style={{ display: "flex", gap: "0.875rem", padding: "0.875rem", borderRadius: 14, textDecoration: "none", color: "inherit", marginBottom: "0.5rem", border: "1px solid transparent", transition: "all 0.2s" }}
                  onMouseEnter={e => { (e.currentTarget as HTMLElement).style.background = "#FFF5F2"; (e.currentTarget as HTMLElement).style.borderColor = "#FFCBB8"; }}
                  onMouseLeave={e => { (e.currentTarget as HTMLElement).style.background = "transparent"; (e.currentTarget as HTMLElement).style.borderColor = "transparent"; }}
                >
                  {p.primary_image ? (
                    <img src={p.primary_image} alt={p.title} style={{ width: 64, height: 64, borderRadius: 10, objectFit: "cover", flexShrink: 0 }} />
                  ) : (
                    <div style={{ width: 64, height: 64, borderRadius: 10, background: "linear-gradient(135deg,#FF6B35,#FF8F64)", display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0, fontSize: "1.5rem" }}>🏠</div>
                  )}
                  <div style={{ flex: 1, overflow: "hidden" }}>
                    <p style={{ fontFamily: "Poppins, sans-serif", fontWeight: 600, fontSize: "0.875rem", color: "#212121", marginBottom: "0.2rem", whiteSpace: "nowrap", overflow: "hidden", textOverflow: "ellipsis" }}>{p.title}</p>
                    <p style={{ fontSize: "0.8rem", color: "#757575", display: "flex", alignItems: "center", gap: "0.25rem", marginBottom: "0.3rem" }}>
                      <MapPin size={11} /> {p.address}
                    </p>
                    <p style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "0.9rem", color: "#FF6B35" }}>
                      ${p.price.toLocaleString("es-AR")}/noche
                    </p>
                  </div>
                </Link>
              ))
            )}
          </div>
        </div>

        {/* Toggle button */}
        <button
          onClick={() => setSidebarOpen(o => !o)}
          style={{
            position: "absolute",
            left: sidebarOpen ? 360 : 0,
            top: "50%",
            transform: "translateY(-50%)",
            zIndex: 10,
            background: "#fff",
            border: "1px solid #EEEEEE",
            borderLeft: "none",
            borderRadius: "0 12px 12px 0",
            padding: "0.875rem 0.4rem",
            cursor: "pointer",
            boxShadow: "2px 0 8px rgba(0,0,0,0.08)",
            transition: "left 0.3s cubic-bezier(0.4,0,0.2,1)",
            color: "#757575",
          }}
        >
          {sidebarOpen ? <ChevronLeft size={18} /> : <ChevronRight size={18} />}
        </button>

        {/* Map */}
        <div style={{ flex: 1, position: "relative" }}>
          <MapView properties={properties} />
        </div>
      </div>
    </>
  );
}
