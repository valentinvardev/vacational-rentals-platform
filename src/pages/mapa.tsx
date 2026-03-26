import Head from "next/head";
import dynamic from "next/dynamic";
import { useEffect, useState } from "react";
import { ChevronLeft, ChevronRight, MapPin } from "lucide-react";
import Link from "next/link";
import type { Property } from "~/components/PropertyCard";

const MapView = dynamic(() => import("~/components/MapView"), {
  ssr: false,
  loading: () => (
    <div style={{ height: "100%", display: "flex", alignItems: "center", justifyContent: "center", background: "var(--gray-100)" }}>
      <div className="spinner" />
    </div>
  ),
});

export default function MapaPage() {
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading]       = useState(true);
  const [open, setOpen]             = useState(true);

  useEffect(() => {
    fetch("/api/properties?limit=100")
      .then(r => r.json())
      .then((d: { data?: Property[] } | Property[]) => {
        setProperties(Array.isArray(d) ? d : ((d as { data?: Property[] }).data ?? []));
      })
      .catch(() => setProperties([]))
      .finally(() => setLoading(false));
  }, []);

  return (
    <>
      <Head>
        <title>Mapa de Hospedajes — Villa Carlos Paz | RentaTurista</title>
        <meta name="description" content="Mapa interactivo de hospedajes en Villa Carlos Paz." />
      </Head>

      <div style={{ paddingTop: "var(--header-height)" }}>
        <div className="map-layout">
          {/* Sidebar */}
          <div className="map-sidebar" style={{ width: open ? 360 : 0, minWidth: open ? 360 : 0 }}>
            <div className="map-sidebar-header">
              {properties.length} hospedajes en el mapa
            </div>
            <div className="map-sidebar-list">
              {loading
                ? [...Array(6)].map((_, i) => <div key={i} className="skeleton" style={{ height: 80, marginBottom: ".75rem" }} />)
                : properties.map(p => (
                    <Link key={p.id} href={`/propiedad/${p.id}`} className="map-property-item">
                      {p.primary_image
                        ? <img src={p.primary_image} alt={p.title} className="map-property-thumb" />
                        : <div className="map-property-thumb-placeholder">🏠</div>
                      }
                      <div className="map-property-info">
                        <p className="map-property-name">{p.title}</p>
                        <p className="map-property-addr"><MapPin size={11} /> {p.address}</p>
                        <p className="map-property-price">${p.price.toLocaleString("es-AR")}/noche</p>
                      </div>
                    </Link>
                  ))
              }
            </div>
          </div>

          {/* Toggle */}
          <button
            className="sidebar-toggle"
            style={{ left: open ? 360 : 0 }}
            onClick={() => setOpen(o => !o)}
          >
            {open ? <ChevronLeft size={18} /> : <ChevronRight size={18} />}
          </button>

          {/* Map */}
          <div style={{ flex: 1, position: "relative" }}>
            <MapView properties={properties} />
          </div>
        </div>
      </div>
    </>
  );
}
