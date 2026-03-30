import type { ReactNode } from "react";
import { useEffect, useState, useCallback } from "react";
import { useRouter } from "next/router";
import { ChevronLeft, ChevronRight, Lock, Unlock, DollarSign, X, RefreshCw } from "lucide-react";
import { withAdminLayout } from "~/components/AdminLayout";

interface AvailDay { date: string; status: string; price?: number; notes?: string }
interface PropertyOption { id: number; title: string }

const MONTHS_ES = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const DAYS_ES   = ["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"];

const STATUS_STYLE: Record<string, React.CSSProperties> = {
  available: { background: "rgba(16,185,129,0.12)", borderColor: "#10B981" },
  booked:    { background: "rgba(239,68,68,0.12)",  borderColor: "#EF4444", cursor: "not-allowed" },
  blocked:   { background: "rgba(158,158,158,0.12)", borderColor: "#9E9E9E" },
};

export default function CalendarioPage() {
  const router = useRouter();
  const { id } = router.query;
  const propertyId = id as string;

  const [today]   = useState(new Date());
  const [curDate, setCurDate] = useState(new Date());
  const [avail, setAvail]     = useState<Record<string, AvailDay>>({});
  const [selected, setSelected] = useState<Set<string>>(new Set());
  const [loading, setLoading]   = useState(false);

  // Modals
  const [blockModal,   setBlockModal]   = useState(false);
  const [blockNotes,   setBlockNotes]   = useState("");
  const [pricingModal, setPricingModal] = useState(false);
  const [specialPrice, setSpecialPrice] = useState("");
  const [pricingNotes, setPricingNotes] = useState("");
  const [saving, setSaving] = useState(false);
  const [toast, setToast]   = useState("");

  const showToast = (msg: string) => {
    setToast(msg);
    setTimeout(() => setToast(""), 3000);
  };

  const loadCalendar = useCallback(() => {
    if (!propertyId) return;
    setLoading(true);
    const year  = curDate.getFullYear();
    const month = curDate.getMonth();
    const start = `${year}-${String(month + 1).padStart(2, "0")}-01`;
    const lastD = new Date(year, month + 1, 0).getDate();
    const end   = `${year}-${String(month + 1).padStart(2, "0")}-${String(lastD).padStart(2, "0")}`;

    fetch(`/api/admin/properties/${propertyId}/availability?start_date=${start}&end_date=${end}`)
      .then(r => r.json())
      .then((d: { data: AvailDay[] }) => {
        const map: Record<string, AvailDay> = {};
        (d.data ?? []).forEach(day => { map[day.date.slice(0, 10)] = day; });
        setAvail(map);
      })
      .catch(console.error)
      .finally(() => setLoading(false));
  }, [propertyId, curDate]);

  useEffect(() => { loadCalendar(); }, [loadCalendar]);

  const toggleDate = (dateStr: string, status: string) => {
    if (status === "booked") return;
    setSelected(s => {
      const next = new Set(s);
      next.has(dateStr) ? next.delete(dateStr) : next.add(dateStr);
      return next;
    });
  };

  const clearSelection = () => setSelected(new Set());

  const doAction = async (body: object) => {
    setSaving(true);
    try {
      const res = await fetch(`/api/admin/properties/${propertyId}/availability`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ dates: Array.from(selected), ...body }),
      });
      if (!res.ok) throw new Error("Error");
      clearSelection();
      loadCalendar();
      showToast("✓ Cambios guardados");
    } catch { showToast("✗ Error al guardar"); }
    finally { setSaving(false); }
  };

  const confirmBlock = async () => {
    await doAction({ action: "block", notes: blockNotes });
    setBlockModal(false);
    setBlockNotes("");
  };

  const confirmUnblock = async () => {
    await doAction({ action: "unblock" });
  };

  const confirmPricing = async () => {
    if (!specialPrice) return;
    await doAction({ action: "price", price: parseFloat(specialPrice), notes: pricingNotes || "Precio especial" });
    setPricingModal(false);
    setSpecialPrice("");
    setPricingNotes("");
  };

  // Build calendar grid
  const year  = curDate.getFullYear();
  const month = curDate.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const cells: { day: number; dateStr: string; avDay: AvailDay | undefined; isToday: boolean; isPast: boolean }[] = [];
  for (let d = 1; d <= daysInMonth; d++) {
    const dt = new Date(year, month, d);
    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(d).padStart(2, "0")}`;
    cells.push({
      day: d,
      dateStr,
      avDay: avail[dateStr],
      isToday: dt.toDateString() === today.toDateString(),
      isPast:  dt < new Date(today.getFullYear(), today.getMonth(), today.getDate()),
    });
  }

  const hasSelection = selected.size > 0;

  return (
    <div>
      {/* Toast */}
      {toast && (
        <div style={{ position: "fixed", bottom: "2rem", right: "2rem", background: toast.startsWith("✓") ? "#10B981" : "#EF4444", color: "#fff", padding: "0.75rem 1.25rem", borderRadius: 12, fontWeight: 700, zIndex: 9999, boxShadow: "0 8px 24px rgba(0,0,0,0.2)" }}>
          {toast}
        </div>
      )}

      {/* Calendar card */}
      <div style={{ background: "rgba(255,255,255,0.88)", backdropFilter: "blur(10px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 18, padding: "1.5rem", marginBottom: "1.5rem" }}>
        {/* Month nav */}
        <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: "1.5rem" }}>
          <div style={{ display: "flex", alignItems: "center", gap: "0.75rem" }}>
            <button onClick={() => setCurDate(d => new Date(d.getFullYear(), d.getMonth() - 1, 1))} style={{ width: 36, height: 36, display: "flex", alignItems: "center", justifyContent: "center", background: "rgba(255,107,53,0.1)", border: "2px solid #FF6B35", borderRadius: 8, color: "#FF6B35", cursor: "pointer" }}>
              <ChevronLeft size={18} />
            </button>
            <h2 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.375rem", color: "#212121" }}>
              {MONTHS_ES[month]} {year}
            </h2>
            <button onClick={() => setCurDate(d => new Date(d.getFullYear(), d.getMonth() + 1, 1))} style={{ width: 36, height: 36, display: "flex", alignItems: "center", justifyContent: "center", background: "rgba(255,107,53,0.1)", border: "2px solid #FF6B35", borderRadius: 8, color: "#FF6B35", cursor: "pointer" }}>
              <ChevronRight size={18} />
            </button>
          </div>
          <button onClick={loadCalendar} style={{ display: "flex", alignItems: "center", gap: "0.375rem", padding: "0.5rem 0.875rem", background: "rgba(255,107,53,0.1)", border: "2px solid #FF6B35", borderRadius: 8, color: "#FF6B35", fontWeight: 600, fontSize: "0.85rem", cursor: "pointer" }}>
            <RefreshCw size={14} /> Actualizar
          </button>
        </div>

        {/* Day headers */}
        <div style={{ display: "grid", gridTemplateColumns: "repeat(7,1fr)", gap: "0.25rem", marginBottom: "0.25rem" }}>
          {DAYS_ES.map(d => (
            <div key={d} style={{ textAlign: "center", fontWeight: 700, fontSize: "0.8rem", color: "#9E9E9E", padding: "0.5rem 0" }}>{d}</div>
          ))}
        </div>

        {/* Grid */}
        {loading ? (
          <div style={{ textAlign: "center", padding: "3rem", color: "#9E9E9E" }}>Cargando...</div>
        ) : (
          <div style={{ display: "grid", gridTemplateColumns: "repeat(7,1fr)", gap: "0.25rem" }}>
            {/* Empty cells */}
            {Array.from({ length: firstDay }).map((_, i) => <div key={`e${i}`} />)}

            {cells.map(({ day, dateStr, avDay, isToday, isPast }) => {
              const status = avDay?.status ?? "available";
              const isSel  = selected.has(dateStr);
              const hasSpecialPrice = !!(avDay?.price);

              const base: React.CSSProperties = {
                aspectRatio: "1",
                border: "2px solid",
                borderRadius: 10,
                display: "flex", flexDirection: "column",
                alignItems: "center", justifyContent: "center",
                cursor: status === "booked" || isPast ? "not-allowed" : "pointer",
                transition: "all 0.2s",
                opacity: isPast ? 0.4 : 1,
                position: "relative",
                padding: "0.25rem",
                fontSize: "0.85rem",
                ...(STATUS_STYLE[status] ?? {}),
              };

              if (isSel) {
                base.background = "rgba(255,107,53,0.18)";
                base.borderColor = "#FF6B35";
                base.borderWidth = "3px";
              }
              if (isToday) {
                base.borderColor = "#3B82F6";
                base.boxShadow = "0 0 0 2px rgba(59,130,246,0.2)";
              }

              return (
                <div key={dateStr} style={base} onClick={() => !isPast && toggleDate(dateStr, status)}>
                  {hasSpecialPrice && (
                    <span style={{ position: "absolute", top: 3, left: 3, color: "#F59E0B", fontSize: "0.6rem", fontWeight: 900 }}>★</span>
                  )}
                  <span style={{ fontWeight: 700, color: "#212121" }}>{day}</span>
                  {avDay?.price && (
                    <span style={{ fontSize: "0.6rem", color: "#F59E0B", fontWeight: 700 }}>
                      ${avDay.price.toLocaleString("es-AR")}
                    </span>
                  )}
                  <span style={{ position: "absolute", top: 3, right: 3, width: 7, height: 7, borderRadius: "50%", background: { available: "#10B981", booked: "#EF4444", blocked: "#9E9E9E" }[status] ?? "#9E9E9E" }} />
                </div>
              );
            })}
          </div>
        )}

        {/* Legend */}
        <div style={{ display: "flex", gap: "1.5rem", marginTop: "1.25rem", flexWrap: "wrap" }}>
          {[
            { label: "Disponible", color: "#10B981", bg: "rgba(16,185,129,0.12)" },
            { label: "Reservado",  color: "#EF4444", bg: "rgba(239,68,68,0.12)" },
            { label: "Bloqueado",  color: "#9E9E9E", bg: "rgba(158,158,158,0.12)" },
            { label: "Hoy",       color: "#3B82F6", bg: "transparent" },
          ].map(({ label, color, bg }) => (
            <div key={label} style={{ display: "flex", alignItems: "center", gap: "0.4rem", fontSize: "0.8rem", fontWeight: 600 }}>
              <div style={{ width: 18, height: 18, border: `2px solid ${color}`, borderRadius: 5, background: bg }} />
              {label}
            </div>
          ))}
          <div style={{ display: "flex", alignItems: "center", gap: "0.4rem", fontSize: "0.8rem", fontWeight: 600 }}>
            <span style={{ color: "#F59E0B", fontWeight: 900 }}>★</span> Precio especial
          </div>
        </div>
      </div>

      {/* Actions */}
      <div style={{ background: "rgba(255,255,255,0.88)", backdropFilter: "blur(10px)", border: "2px solid rgba(101,67,33,0.08)", borderRadius: 18, padding: "1.5rem" }}>
        <h3 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, marginBottom: "1rem" }}>
          Acciones rápidas
          {hasSelection && <span style={{ marginLeft: "0.625rem", background: "#FF6B35", color: "#fff", borderRadius: 20, padding: "0.2rem 0.6rem", fontSize: "0.75rem" }}>{selected.size} seleccionados</span>}
        </h3>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit,minmax(200px,1fr))", gap: "0.75rem" }}>
          <button disabled={!hasSelection || saving} onClick={() => setBlockModal(true)} style={{ display: "flex", alignItems: "center", justifyContent: "center", gap: "0.5rem", padding: "0.875rem", background: hasSelection ? "linear-gradient(135deg,#FF6B35,#E55527)" : "#E0E0E0", color: "#fff", border: "none", borderRadius: 12, fontWeight: 700, cursor: hasSelection ? "pointer" : "not-allowed" }}>
            <Lock size={16} /> Bloquear
          </button>
          <button disabled={!hasSelection || saving} onClick={confirmUnblock} style={{ display: "flex", alignItems: "center", justifyContent: "center", gap: "0.5rem", padding: "0.875rem", background: "rgba(255,107,53,0.1)", color: "#FF6B35", border: "2px solid #FF6B35", borderRadius: 12, fontWeight: 700, cursor: hasSelection ? "pointer" : "not-allowed", opacity: hasSelection ? 1 : 0.5 }}>
            <Unlock size={16} /> Liberar
          </button>
          <button disabled={!hasSelection || saving} onClick={() => setPricingModal(true)} style={{ display: "flex", alignItems: "center", justifyContent: "center", gap: "0.5rem", padding: "0.875rem", background: hasSelection ? "rgba(245,158,11,0.15)" : "#E0E0E0", color: hasSelection ? "#D97706" : "#9E9E9E", border: `2px solid ${hasSelection ? "#F59E0B" : "#E0E0E0"}`, borderRadius: 12, fontWeight: 700, cursor: hasSelection ? "pointer" : "not-allowed" }}>
            <DollarSign size={16} /> Precio especial
          </button>
          <button disabled={!hasSelection} onClick={clearSelection} style={{ display: "flex", alignItems: "center", justifyContent: "center", gap: "0.5rem", padding: "0.875rem", background: "#fff", color: "#757575", border: "2px solid #E0E0E0", borderRadius: 12, fontWeight: 600, cursor: "pointer", opacity: hasSelection ? 1 : 0.5 }}>
            <X size={16} /> Limpiar selección
          </button>
        </div>
      </div>

      {/* Block Modal */}
      {blockModal && (
        <div style={{ position: "fixed", inset: 0, background: "rgba(0,0,0,0.55)", backdropFilter: "blur(4px)", zIndex: 9999, display: "flex", alignItems: "center", justifyContent: "center", padding: "1rem" }}>
          <div style={{ background: "#fff", borderRadius: 20, padding: "2rem", maxWidth: 420, width: "100%" }}>
            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: "1.25rem" }}>
              <h3 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.25rem" }}>Bloquear {selected.size} fecha(s)</h3>
              <button onClick={() => setBlockModal(false)} style={{ background: "none", border: "none", cursor: "pointer", color: "#9E9E9E" }}><X size={20} /></button>
            </div>
            <label style={{ display: "block", fontWeight: 600, marginBottom: "0.4rem", fontSize: "0.9rem" }}>Motivo (opcional)</label>
            <input value={blockNotes} onChange={e => setBlockNotes(e.target.value)} placeholder="Ej: Mantenimiento, Personal..." style={{ width: "100%", padding: "0.75rem", border: "2px solid #E0E0E0", borderRadius: 10, fontSize: "0.95rem", outline: "none", marginBottom: "1.25rem" }} />
            <div style={{ display: "flex", gap: "0.75rem" }}>
              <button onClick={() => setBlockModal(false)} style={{ flex: 1, padding: "0.75rem", border: "2px solid #E0E0E0", borderRadius: 10, fontWeight: 600, cursor: "pointer", background: "#fff" }}>Cancelar</button>
              <button onClick={confirmBlock} disabled={saving} style={{ flex: 1, padding: "0.75rem", background: "linear-gradient(135deg,#FF6B35,#E55527)", color: "#fff", border: "none", borderRadius: 10, fontWeight: 700, cursor: "pointer" }}>
                {saving ? "Guardando..." : "Confirmar"}
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Pricing Modal */}
      {pricingModal && (
        <div style={{ position: "fixed", inset: 0, background: "rgba(0,0,0,0.55)", backdropFilter: "blur(4px)", zIndex: 9999, display: "flex", alignItems: "center", justifyContent: "center", padding: "1rem" }}>
          <div style={{ background: "#fff", borderRadius: 20, padding: "2rem", maxWidth: 420, width: "100%" }}>
            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: "1.25rem" }}>
              <h3 style={{ fontFamily: "var(--font-primary)", fontWeight: 700, fontSize: "1.25rem" }}>Precio especial — {selected.size} fecha(s)</h3>
              <button onClick={() => setPricingModal(false)} style={{ background: "none", border: "none", cursor: "pointer", color: "#9E9E9E" }}><X size={20} /></button>
            </div>
            <label style={{ display: "block", fontWeight: 600, marginBottom: "0.4rem", fontSize: "0.9rem" }}>Precio por noche ($)</label>
            <input type="number" value={specialPrice} onChange={e => setSpecialPrice(e.target.value)} placeholder="50000" style={{ width: "100%", padding: "0.75rem", border: "2px solid #E0E0E0", borderRadius: 10, fontSize: "0.95rem", outline: "none", marginBottom: "0.875rem" }} />
            <label style={{ display: "block", fontWeight: 600, marginBottom: "0.4rem", fontSize: "0.9rem" }}>Motivo (opcional)</label>
            <input value={pricingNotes} onChange={e => setPricingNotes(e.target.value)} placeholder="Ej: Temporada alta, Fin de semana largo" style={{ width: "100%", padding: "0.75rem", border: "2px solid #E0E0E0", borderRadius: 10, fontSize: "0.95rem", outline: "none", marginBottom: "1.25rem" }} />
            <div style={{ display: "flex", gap: "0.75rem" }}>
              <button onClick={() => setPricingModal(false)} style={{ flex: 1, padding: "0.75rem", border: "2px solid #E0E0E0", borderRadius: 10, fontWeight: 600, cursor: "pointer", background: "#fff" }}>Cancelar</button>
              <button onClick={confirmPricing} disabled={saving || !specialPrice} style={{ flex: 1, padding: "0.75rem", background: "linear-gradient(135deg,#F59E0B,#D97706)", color: "#fff", border: "none", borderRadius: 10, fontWeight: 700, cursor: "pointer" }}>
                {saving ? "Guardando..." : "Confirmar"}
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

CalendarioPage.getLayout = (page: ReactNode) => withAdminLayout("Calendario de Disponibilidad")(page);
