import type { ReactNode } from "react";
import { useEffect, useState } from "react";
import Link from "next/link";
import { useRouter } from "next/router";
import { Building2, Edit2, Trash2, Calendar, Star, MapPin, Bed, Bath, Users, Search, TrendingUp, DollarSign, MessageSquare } from "lucide-react";
import { withAdminLayout } from "~/components/AdminLayout";

interface AdminProperty {
  id: number;
  title: string;
  address: string;
  price: number;
  beds: number;
  baths: number;
  guests: number;
  rating?: number;
  reviews_count: number;
  type_name?: string;
  status: string;
  images: { url: string; is_primary: boolean }[];
  _count: { reviews: number; amenities: number };
}

interface Stats {
  total: number;
  active: number;
  avgPrice: number;
  totalReviews: number;
}

const STATUS_LABEL: Record<string, { label: string; color: string; bg: string }> = {
  active:   { label: "Activo",    color: "#10B981", bg: "rgba(16,185,129,0.1)" },
  draft:    { label: "Borrador",  color: "#F59E0B", bg: "rgba(245,158,11,0.1)" },
  inactive: { label: "Inactivo", color: "#9E9E9E", bg: "rgba(158,158,158,0.1)" },
};

export default function AdminPropiedades() {
  const router = useRouter();
  const [properties, setProperties] = useState<AdminProperty[]>([]);
  const [stats, setStats] = useState<Stats>({ total: 0, active: 0, avgPrice: 0, totalReviews: 0 });
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [filter, setFilter] = useState("todos");
  const [deleteId, setDeleteId] = useState<number | null>(null);
  const [deleting, setDeleting] = useState(false);

  const load = () => {
    setLoading(true);
    fetch("/api/admin/properties")
      .then(r => r.json())
      .then((d: { data: AdminProperty[]; stats: Stats }) => {
        setProperties(d.data ?? []);
        setStats(d.stats ?? { total: 0, active: 0, avgPrice: 0, totalReviews: 0 });
      })
      .catch(console.error)
      .finally(() => setLoading(false));
  };

  useEffect(() => { load(); }, []);

  const filtered = properties.filter(p => {
    const matchSearch = !search || p.title.toLowerCase().includes(search.toLowerCase()) || p.address.toLowerCase().includes(search.toLowerCase());
    const matchFilter = filter === "todos" || p.status === filter;
    return matchSearch && matchFilter;
  });

  const handleDelete = async () => {
    if (!deleteId) return;
    setDeleting(true);
    try {
      await fetch(`/api/admin/properties/${deleteId}`, { method: "DELETE" });
      setDeleteId(null);
      load();
    } finally {
      setDeleting(false);
    }
  };

  const STAT_CARDS = [
    { label: "Total Propiedades", value: stats.total, Icon: Building2, color: "#FF6B35" },
    { label: "Activas", value: stats.active, Icon: TrendingUp, color: "#10B981" },
    { label: "Precio Promedio", value: `$${stats.avgPrice.toLocaleString("es-AR")}`, Icon: DollarSign, color: "#3B82F6" },
    { label: "Reseñas totales", value: stats.totalReviews, Icon: MessageSquare, color: "#8B5CF6" },
  ];

  return (
    <>
      {/* Stats */}
      <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit,minmax(220px,1fr))", gap: "1.25rem", marginBottom: "2rem" }}>
        {STAT_CARDS.map(({ label, value, Icon, color }) => (
          <div key={label} style={{ background: "rgba(255,255,255,0.85)", backdropFilter: "blur(10px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 16, padding: "1.25rem", transition: "all 0.3s" }}>
            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-start", marginBottom: "0.75rem" }}>
              <div style={{ width: 44, height: 44, background: `${color}20`, borderRadius: 12, display: "flex", alignItems: "center", justifyContent: "center", color }}>
                <Icon size={22} />
              </div>
            </div>
            <div style={{ fontFamily: "var(--font-primary)", fontWeight: 800, fontSize: "1.75rem", color: "#212121" }}>{value}</div>
            <div style={{ color: "#757575", fontSize: "0.875rem", fontWeight: 600, marginTop: "0.2rem" }}>{label}</div>
          </div>
        ))}
      </div>

      {/* Controls */}
      <div style={{ background: "rgba(255,255,255,0.7)", backdropFilter: "blur(12px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 16, padding: "1.25rem", marginBottom: "1.5rem" }}>
        <div style={{ position: "relative", marginBottom: "0.875rem" }}>
          <Search size={16} style={{ position: "absolute", left: "1rem", top: "50%", transform: "translateY(-50%)", color: "#9E9E9E" }} />
          <input
            type="text"
            placeholder="Buscar por título o dirección..."
            value={search}
            onChange={e => setSearch(e.target.value)}
            style={{ width: "100%", padding: "0.75rem 1rem 0.75rem 2.75rem", border: "2px solid #E0E0E0", borderRadius: 12, fontSize: "0.95rem", outline: "none", fontFamily: "var(--font-body)" }}
          />
        </div>
        <div style={{ display: "flex", gap: "0.5rem", flexWrap: "wrap" }}>
          {["todos", "active", "draft", "inactive"].map(f => (
            <button key={f} onClick={() => setFilter(f)} style={{
              padding: "0.4rem 0.9rem", borderRadius: 20, border: "2px solid",
              borderColor: filter === f ? "#FF6B35" : "#E0E0E0",
              background: filter === f ? "rgba(255,107,53,0.1)" : "#fff",
              color: filter === f ? "#FF6B35" : "#757575",
              fontWeight: 600, fontSize: "0.85rem", cursor: "pointer",
            }}>
              {{ todos: "Todos", active: "Activos", draft: "Borradores", inactive: "Inactivos" }[f]}
            </button>
          ))}
        </div>
      </div>

      {/* Grid */}
      {loading ? (
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill,minmax(340px,1fr))", gap: "1.5rem" }}>
          {[...Array(6)].map((_, i) => <div key={i} className="skeleton" style={{ height: 340, borderRadius: 16 }} />)}
        </div>
      ) : filtered.length === 0 ? (
        <div className="empty-state">
          <div className="empty-state-icon">🏠</div>
          <h3>No hay propiedades</h3>
          <p><Link href="/admin/propiedades/nueva" style={{ color: "#FF6B35", fontWeight: 600 }}>Crear la primera propiedad</Link></p>
        </div>
      ) : (
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill,minmax(340px,1fr))", gap: "1.5rem" }}>
          {filtered.map(p => {
            const st = STATUS_LABEL[p.status] ?? STATUS_LABEL.inactive!;
            const img = p.images[0]?.url;
            return (
              <div key={p.id} style={{ background: "rgba(255,255,255,0.92)", backdropFilter: "blur(8px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 18, overflow: "hidden", transition: "all 0.3s" }}>
                {/* Image */}
                <div style={{ height: 200, background: "linear-gradient(135deg,#FF8F64,#FF6B35)", position: "relative", overflow: "hidden" }}>
                  {img && <img src={img} alt={p.title} style={{ width: "100%", height: "100%", objectFit: "cover" }} />}
                  {p.type_name && (
                    <span style={{ position: "absolute", top: 12, left: 12, background: "rgba(0,0,0,0.65)", backdropFilter: "blur(8px)", color: "#fff", padding: "0.3rem 0.75rem", borderRadius: 20, fontSize: "0.75rem", fontWeight: 700, textTransform: "uppercase" }}>
                      {p.type_name}
                    </span>
                  )}
                  <span style={{ position: "absolute", top: 12, right: 12, background: st.bg, color: st.color, padding: "0.3rem 0.75rem", borderRadius: 20, fontSize: "0.75rem", fontWeight: 700 }}>
                    {st.label}
                  </span>
                </div>

                {/* Body */}
                <div style={{ padding: "1.1rem" }}>
                  <h3 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.05rem", color: "#212121", marginBottom: "0.4rem", lineHeight: 1.3 }}>{p.title}</h3>
                  <p style={{ display: "flex", alignItems: "center", gap: "0.3rem", color: "#757575", fontSize: "0.85rem", marginBottom: "0.75rem" }}>
                    <MapPin size={13} /> {p.address}
                  </p>
                  <div style={{ display: "flex", gap: "1rem", marginBottom: "0.75rem", paddingBottom: "0.75rem", borderBottom: "1px solid #F0F0F0" }}>
                    <span style={{ display: "flex", alignItems: "center", gap: "0.3rem", color: "#757575", fontSize: "0.8rem" }}><Bed size={13} /> {p.beds} hab.</span>
                    <span style={{ display: "flex", alignItems: "center", gap: "0.3rem", color: "#757575", fontSize: "0.8rem" }}><Bath size={13} /> {p.baths} baños</span>
                    <span style={{ display: "flex", alignItems: "center", gap: "0.3rem", color: "#757575", fontSize: "0.8rem" }}><Users size={13} /> {p.guests} huésp.</span>
                    {p.rating != null && (
                      <span style={{ display: "flex", alignItems: "center", gap: "0.3rem", color: "#F59E0B", fontSize: "0.8rem", marginLeft: "auto" }}>
                        <Star size={13} style={{ fill: "#F59E0B" }} /> {p.rating.toFixed(1)}
                      </span>
                    )}
                  </div>
                  <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}>
                    <span style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.1rem", color: "#FF6B35" }}>
                      ${p.price.toLocaleString("es-AR")}<span style={{ fontWeight: 400, fontSize: "0.8rem", color: "#9E9E9E" }}>/noche</span>
                    </span>
                    <div style={{ display: "flex", gap: "0.5rem" }}>
                      <Link href={`/admin/propiedades/${p.id}/calendario`} title="Calendario" style={{ width: 36, height: 36, display: "flex", alignItems: "center", justifyContent: "center", background: "rgba(59,130,246,0.1)", border: "2px solid #3B82F6", borderRadius: 10, color: "#3B82F6", textDecoration: "none" }}>
                        <Calendar size={16} />
                      </Link>
                      <Link href={`/admin/propiedades/${p.id}/editar`} title="Editar" style={{ width: 36, height: 36, display: "flex", alignItems: "center", justifyContent: "center", background: "rgba(255,107,53,0.1)", border: "2px solid #FF6B35", borderRadius: 10, color: "#FF6B35", textDecoration: "none" }}>
                        <Edit2 size={16} />
                      </Link>
                      <button title="Eliminar" onClick={() => setDeleteId(p.id)} style={{ width: 36, height: 36, display: "flex", alignItems: "center", justifyContent: "center", background: "rgba(239,68,68,0.1)", border: "2px solid #EF4444", borderRadius: 10, color: "#EF4444", cursor: "pointer" }}>
                        <Trash2 size={16} />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      )}

      {/* Delete modal */}
      {deleteId !== null && (
        <div style={{ position: "fixed", inset: 0, background: "rgba(0,0,0,0.6)", backdropFilter: "blur(4px)", zIndex: 9999, display: "flex", alignItems: "center", justifyContent: "center", padding: "1rem" }}>
          <div style={{ background: "#fff", borderRadius: 20, padding: "2rem", maxWidth: 440, width: "100%", textAlign: "center" }}>
            <div style={{ width: 64, height: 64, background: "rgba(239,68,68,0.1)", borderRadius: "50%", display: "flex", alignItems: "center", justifyContent: "center", margin: "0 auto 1.25rem", color: "#EF4444" }}>
              <Trash2 size={28} />
            </div>
            <h3 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.375rem", marginBottom: "0.5rem" }}>¿Eliminar propiedad?</h3>
            <p style={{ color: "#757575", marginBottom: "1.5rem" }}>Esta acción no se puede deshacer. Se eliminarán también las imágenes, amenidades, reseñas y disponibilidad.</p>
            <div style={{ display: "flex", gap: "0.75rem" }}>
              <button onClick={() => setDeleteId(null)} style={{ flex: 1, padding: "0.75rem", border: "2px solid #E0E0E0", borderRadius: 12, fontWeight: 600, cursor: "pointer", background: "#fff" }}>
                Cancelar
              </button>
              <button onClick={handleDelete} disabled={deleting} style={{ flex: 1, padding: "0.75rem", background: "linear-gradient(135deg,#EF4444,#DC2626)", color: "#fff", border: "none", borderRadius: 12, fontWeight: 700, cursor: "pointer" }}>
                {deleting ? "Eliminando..." : "Sí, eliminar"}
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}

AdminPropiedades.getLayout = withAdminLayout("Gestión de Propiedades");
