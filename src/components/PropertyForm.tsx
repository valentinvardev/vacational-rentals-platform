import { useState } from "react";
import { useRouter } from "next/router";
import { Home, FileText, DollarSign, Image, Plus, Trash2, Save, Loader } from "lucide-react";

export interface PropertyFormData {
  title: string;
  description: string;
  type_name: string;
  address: string;
  beds: string;
  baths: string;
  guests: string;
  price: string;
  rating: string;
  status: string;
  lat: string;
  lng: string;
  amenities: { name: string; icon: string }[];
  images: { url: string; is_primary: boolean }[];
}

const AMENITY_PRESETS = [
  { name: "Wi-Fi", icon: "wifi" }, { name: "Smart TV", icon: "tv" },
  { name: "Estacionamiento", icon: "parking" }, { name: "Pileta", icon: "pool" },
  { name: "Aire acondicionado", icon: "ac" }, { name: "Desayuno incluido", icon: "breakfast" },
  { name: "Parrilla", icon: "grill" }, { name: "Lavadero", icon: "laundry" },
  { name: "Pet Friendly", icon: "pet" }, { name: "Gimnasio", icon: "gym" },
  { name: "Jacuzzi", icon: "jacuzzi" }, { name: "Fogón", icon: "fire" },
];

const PROPERTY_TYPES = ["Casa", "Departamento", "Cabaña", "Loft", "Villa", "Suite", "Hostel"];

interface Props {
  initial?: Partial<PropertyFormData>;
  mode: "create" | "edit";
  onSubmit: (data: PropertyFormData) => Promise<void>;
}

const S = {
  label: { display: "block", fontWeight: 600, color: "#424242", marginBottom: "0.4rem", fontSize: "0.9rem" } as React.CSSProperties,
  input: { width: "100%", padding: "0.7rem 0.875rem", border: "2px solid #E0E0E0", borderRadius: 10, fontSize: "0.95rem", fontFamily: "var(--font-body)", outline: "none", transition: "border-color 0.2s", background: "#fff" } as React.CSSProperties,
  section: { background: "rgba(255,255,255,0.85)", backdropFilter: "blur(8px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 16, padding: "1.5rem", marginBottom: "1.5rem" } as React.CSSProperties,
  sectionTitle: { fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.05rem", color: "#212121", marginBottom: "1.25rem", display: "flex", alignItems: "center", gap: "0.5rem", paddingBottom: "0.75rem", borderBottom: "2px solid rgba(101,67,33,0.08)" } as React.CSSProperties,
};

export default function PropertyForm({ initial, mode, onSubmit }: Props) {
  const router = useRouter();
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState("");

  const [form, setForm] = useState<PropertyFormData>({
    title: initial?.title ?? "",
    description: initial?.description ?? "",
    type_name: initial?.type_name ?? "",
    address: initial?.address ?? "",
    beds: String(initial?.beds ?? "1"),
    baths: String(initial?.baths ?? "1"),
    guests: String(initial?.guests ?? "2"),
    price: String(initial?.price ?? ""),
    rating: String(initial?.rating ?? ""),
    status: initial?.status ?? "active",
    lat: String(initial?.lat ?? ""),
    lng: String(initial?.lng ?? ""),
    amenities: initial?.amenities ?? [],
    images: initial?.images ?? [{ url: "", is_primary: true }],
  });

  const set = (field: keyof PropertyFormData, val: string) =>
    setForm(f => ({ ...f, [field]: val }));

  const toggleAmenity = (preset: { name: string; icon: string }) => {
    setForm(f => {
      const exists = f.amenities.find(a => a.icon === preset.icon);
      return {
        ...f,
        amenities: exists
          ? f.amenities.filter(a => a.icon !== preset.icon)
          : [...f.amenities, preset],
      };
    });
  };

  const addImage = () =>
    setForm(f => ({ ...f, images: [...f.images, { url: "", is_primary: false }] }));

  const removeImage = (i: number) =>
    setForm(f => {
      const imgs = f.images.filter((_, idx) => idx !== i);
      if (imgs.length > 0 && !imgs.some(img => img.is_primary)) imgs[0]!.is_primary = true;
      return { ...f, images: imgs };
    });

  const setPrimary = (i: number) =>
    setForm(f => ({ ...f, images: f.images.map((img, idx) => ({ ...img, is_primary: idx === i })) }));

  const setImageUrl = (i: number, url: string) =>
    setForm(f => ({ ...f, images: f.images.map((img, idx) => idx === i ? { ...img, url } : img) }));

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!form.title || !form.address || !form.price) { setError("Título, dirección y precio son obligatorios."); return; }
    setSaving(true);
    setError("");
    try {
      await onSubmit({ ...form, images: form.images.filter(img => img.url.trim()) });
    } catch (err) {
      setError(err instanceof Error ? err.message : "Error al guardar");
    } finally {
      setSaving(false);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      {error && (
        <div style={{ background: "rgba(239,68,68,0.1)", border: "2px solid #EF4444", borderRadius: 12, padding: "0.875rem 1rem", color: "#DC2626", fontWeight: 600, marginBottom: "1.25rem" }}>
          {error}
        </div>
      )}

      <div style={{ display: "grid", gridTemplateColumns: "1fr 380px", gap: "1.5rem", alignItems: "start" }}>
        {/* LEFT */}
        <div>
          {/* Información básica */}
          <div style={S.section}>
            <div style={S.sectionTitle}><Home size={18} style={{ color: "#FF6B35" }} /> Información básica</div>
            <div style={{ marginBottom: "1rem" }}>
              <label style={S.label}>Título <span style={{ color: "#EF4444" }}>*</span></label>
              <input style={S.input} value={form.title} onChange={e => set("title", e.target.value)} placeholder="Ej: Cabaña en el Bosque — San Marcos Sierras" required />
            </div>
            <div style={{ marginBottom: "1rem" }}>
              <label style={S.label}>Descripción</label>
              <textarea style={{ ...S.input, minHeight: 100, resize: "vertical" }} value={form.description} onChange={e => set("description", e.target.value)} placeholder="Descripción detallada de la propiedad..." />
            </div>
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "0.875rem" }}>
              <div>
                <label style={S.label}>Tipo de propiedad</label>
                <select style={S.input} value={form.type_name} onChange={e => set("type_name", e.target.value)}>
                  <option value="">— Sin tipo —</option>
                  {PROPERTY_TYPES.map(t => <option key={t} value={t}>{t}</option>)}
                </select>
              </div>
              <div>
                <label style={S.label}>Estado</label>
                <select style={S.input} value={form.status} onChange={e => set("status", e.target.value)}>
                  <option value="active">Activo</option>
                  <option value="draft">Borrador</option>
                  <option value="inactive">Inactivo</option>
                </select>
              </div>
            </div>
            <div style={{ marginTop: "0.875rem" }}>
              <label style={S.label}>Dirección <span style={{ color: "#EF4444" }}>*</span></label>
              <input style={S.input} value={form.address} onChange={e => set("address", e.target.value)} placeholder="Ej: Camino al Río 245, Villa Carlos Paz, Córdoba" required />
            </div>
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "0.875rem", marginTop: "0.875rem" }}>
              <div>
                <label style={S.label}>Latitud</label>
                <input style={S.input} type="number" step="any" value={form.lat} onChange={e => set("lat", e.target.value)} placeholder="-31.4201" />
              </div>
              <div>
                <label style={S.label}>Longitud</label>
                <input style={S.input} type="number" step="any" value={form.lng} onChange={e => set("lng", e.target.value)} placeholder="-64.1888" />
              </div>
            </div>
          </div>

          {/* Detalles */}
          <div style={S.section}>
            <div style={S.sectionTitle}><DollarSign size={18} style={{ color: "#FF6B35" }} /> Detalles y precio</div>
            <div style={{ display: "grid", gridTemplateColumns: "repeat(4,1fr)", gap: "0.875rem", marginBottom: "0.875rem" }}>
              {([["beds","Habitaciones"],["baths","Baños"],["guests","Huéspedes"]] as const).map(([field, label]) => (
                <div key={field}>
                  <label style={S.label}>{label}</label>
                  <input style={S.input} type="number" min="1" max="50" value={form[field]} onChange={e => set(field, e.target.value)} />
                </div>
              ))}
              <div>
                <label style={S.label}>Rating (0–5)</label>
                <input style={S.input} type="number" min="0" max="5" step="0.1" value={form.rating} onChange={e => set("rating", e.target.value)} placeholder="4.8" />
              </div>
            </div>
            <div>
              <label style={S.label}>Precio por noche (ARS) <span style={{ color: "#EF4444" }}>*</span></label>
              <input style={{ ...S.input, fontSize: "1.1rem", fontWeight: 700 }} type="number" min="0" value={form.price} onChange={e => set("price", e.target.value)} placeholder="25000" required />
            </div>
          </div>

          {/* Amenidades */}
          <div style={S.section}>
            <div style={S.sectionTitle}><FileText size={18} style={{ color: "#FF6B35" }} /> Servicios y amenidades</div>
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill,minmax(160px,1fr))", gap: "0.625rem" }}>
              {AMENITY_PRESETS.map(preset => {
                const active = form.amenities.some(a => a.icon === preset.icon);
                return (
                  <label key={preset.icon} style={{ display: "flex", alignItems: "center", gap: "0.5rem", padding: "0.625rem 0.75rem", background: active ? "rgba(255,107,53,0.08)" : "#FAFAFA", border: `2px solid ${active ? "#FF6B35" : "#E0E0E0"}`, borderRadius: 10, cursor: "pointer", fontSize: "0.875rem", fontWeight: active ? 700 : 500, color: active ? "#FF6B35" : "#424242", transition: "all 0.2s" }}>
                    <input type="checkbox" checked={active} onChange={() => toggleAmenity(preset)} style={{ display: "none" }} />
                    {preset.name}
                  </label>
                );
              })}
            </div>
          </div>

          {/* Imágenes */}
          <div style={S.section}>
            <div style={S.sectionTitle}><Image size={18} style={{ color: "#FF6B35" }} /> Imágenes (URLs)</div>
            <div style={{ display: "flex", flexDirection: "column", gap: "0.625rem" }}>
              {form.images.map((img, i) => (
                <div key={i} style={{ display: "flex", gap: "0.5rem", alignItems: "center" }}>
                  <input
                    style={{ ...S.input, flex: 1 }}
                    type="url"
                    value={img.url}
                    onChange={e => setImageUrl(i, e.target.value)}
                    placeholder="https://images.unsplash.com/..."
                  />
                  <button type="button" title="Principal" onClick={() => setPrimary(i)} style={{ flexShrink: 0, padding: "0.5rem 0.75rem", borderRadius: 8, border: `2px solid ${img.is_primary ? "#10B981" : "#E0E0E0"}`, background: img.is_primary ? "rgba(16,185,129,0.1)" : "#fff", color: img.is_primary ? "#10B981" : "#9E9E9E", fontWeight: 700, fontSize: "0.75rem", cursor: "pointer" }}>
                    {img.is_primary ? "★ Principal" : "Hacer principal"}
                  </button>
                  {form.images.length > 1 && (
                    <button type="button" onClick={() => removeImage(i)} style={{ flexShrink: 0, width: 34, height: 34, display: "flex", alignItems: "center", justifyContent: "center", background: "rgba(239,68,68,0.1)", border: "2px solid #EF4444", borderRadius: 8, color: "#EF4444", cursor: "pointer" }}>
                      <Trash2 size={14} />
                    </button>
                  )}
                </div>
              ))}
            </div>
            <button type="button" onClick={addImage} style={{ marginTop: "0.75rem", display: "flex", alignItems: "center", gap: "0.4rem", color: "#FF6B35", background: "none", border: "2px dashed #FF6B35", borderRadius: 10, padding: "0.5rem 1rem", cursor: "pointer", fontWeight: 600, fontSize: "0.875rem" }}>
              <Plus size={15} /> Agregar imagen
            </button>
          </div>
        </div>

        {/* RIGHT — sticky summary */}
        <div style={{ position: "sticky", top: 80 }}>
          <div style={{ background: "rgba(255,255,255,0.9)", backdropFilter: "blur(10px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 16, padding: "1.5rem" }}>
            <h3 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.1rem", marginBottom: "1.25rem", color: "#212121" }}>
              {mode === "create" ? "Crear propiedad" : "Guardar cambios"}
            </h3>

            {/* Live preview */}
            <div style={{ background: "#FAFAFA", borderRadius: 12, overflow: "hidden", marginBottom: "1.25rem", border: "2px solid #F0F0F0" }}>
              {form.images[0]?.url ? (
                <img src={form.images[0].url} alt="" style={{ width: "100%", height: 140, objectFit: "cover" }} onError={e => { (e.target as HTMLImageElement).style.display = "none"; }} />
              ) : (
                <div style={{ height: 140, background: "linear-gradient(135deg,#FF8F64,#FF6B35)", display: "flex", alignItems: "center", justifyContent: "center", color: "#fff", fontSize: "2rem" }}>🏠</div>
              )}
              <div style={{ padding: "0.875rem" }}>
                <p style={{ fontWeight: 700, fontSize: "0.95rem", color: "#212121", marginBottom: "0.25rem" }}>{form.title || "Sin título"}</p>
                <p style={{ fontSize: "0.8rem", color: "#9E9E9E" }}>{form.address || "Sin dirección"}</p>
                {form.price && <p style={{ fontWeight: 700, color: "#FF6B35", marginTop: "0.5rem" }}>${parseInt(form.price).toLocaleString("es-AR")}/noche</p>}
              </div>
            </div>

            <button type="submit" disabled={saving} style={{
              width: "100%", padding: "0.875rem", background: saving ? "#E0E0E0" : "linear-gradient(135deg,#FF6B35,#E55527)",
              color: "#fff", border: "none", borderRadius: 12, fontFamily: "var(--font-primary)", fontWeight: 700,
              fontSize: "1rem", cursor: saving ? "not-allowed" : "pointer", display: "flex", alignItems: "center",
              justifyContent: "center", gap: "0.5rem", marginBottom: "0.625rem",
            }}>
              {saving ? <><Loader size={16} style={{ animation: "spin 1s linear infinite" }} /> Guardando...</> : <><Save size={16} /> {mode === "create" ? "Crear Propiedad" : "Guardar Cambios"}</>}
            </button>
            <button type="button" onClick={() => router.back()} style={{ width: "100%", padding: "0.75rem", background: "#fff", border: "2px solid #E0E0E0", borderRadius: 12, fontWeight: 600, cursor: "pointer", color: "#757575" }}>
              Cancelar
            </button>
          </div>
        </div>
      </div>

      <style>{`@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }`}</style>
    </form>
  );
}
