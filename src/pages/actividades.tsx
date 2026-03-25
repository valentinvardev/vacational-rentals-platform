import Head from "next/head";
import { useEffect, useState } from "react";
import { Search } from "lucide-react";
import ActivityCard, { type Activity } from "~/components/ActivityCard";

const CATEGORIES = ["Todos", "Restaurante", "Teatro", "Parque", "Museo", "Aventura", "Playa"];

export default function ActividadesPage() {
  const [activities, setActivities] = useState<Activity[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [category, setCategory] = useState("Todos");

  useEffect(() => {
    const params = new URLSearchParams();
    if (search) params.set("search", search);
    if (category !== "Todos") params.set("category", category.toLowerCase());

    fetch(`/api/places?${params.toString()}`)
      .then(r => r.json())
      .then((data: { data?: Activity[] } | Activity[]) => {
        const arr = Array.isArray(data) ? data : ((data as { data?: Activity[] }).data ?? []);
        setActivities(arr);
      })
      .catch(() => setActivities([]))
      .finally(() => setLoading(false));
  }, [search, category]);

  return (
    <>
      <Head>
        <title>Actividades en Villa Carlos Paz - RentaTurista</title>
        <meta name="description" content="Descubrí las mejores actividades y lugares de interés en Villa Carlos Paz." />
      </Head>

      {/* Header */}
      <section style={{ background: "linear-gradient(135deg, #FFF5F2 0%, #FFFFFF 100%)", padding: "4rem clamp(1.5rem, 5vw, 4rem) 3rem" }}>
        <div style={{ maxWidth: 1400, margin: "0 auto", textAlign: "center" }}>
          <h1 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(2rem, 4vw, 3rem)", color: "#212121", marginBottom: "1rem" }}>
            Actividades y lugares
          </h1>
          <p style={{ fontSize: "1.1rem", color: "#757575", maxWidth: 550, margin: "0 auto 2rem" }}>
            Todo lo que podés hacer en Villa Carlos Paz y alrededores
          </p>

          {/* Search */}
          <div style={{
            display: "flex", gap: "0.75rem", maxWidth: 500, margin: "0 auto",
            background: "#fff", borderRadius: 60, padding: "0.5rem 0.5rem 0.5rem 1.25rem",
            boxShadow: "0 8px 32px rgba(0,0,0,0.1)", border: "1px solid #EEEEEE",
          }}>
            <Search size={20} style={{ color: "#757575", alignSelf: "center", flexShrink: 0 }} />
            <input
              type="text"
              placeholder="Buscar actividades..."
              value={search}
              onChange={e => setSearch(e.target.value)}
              style={{ flex: 1, border: "none", outline: "none", fontSize: "0.95rem", fontFamily: "Poppins, sans-serif", background: "transparent" }}
            />
          </div>
        </div>
      </section>

      <section style={{ padding: "3rem clamp(1.5rem, 5vw, 4rem)" }}>
        <div style={{ maxWidth: 1400, margin: "0 auto" }}>
          {/* Category pills */}
          <div style={{ display: "flex", gap: "0.75rem", flexWrap: "wrap", marginBottom: "2.5rem" }}>
            {CATEGORIES.map(cat => (
              <button
                key={cat}
                onClick={() => setCategory(cat)}
                style={{
                  padding: "0.5rem 1.25rem", borderRadius: 50, border: "2px solid",
                  borderColor: category === cat ? "#FF6B35" : "#E0E0E0",
                  background: category === cat ? "#FF6B35" : "#fff",
                  color: category === cat ? "#fff" : "#757575",
                  fontFamily: "Poppins, sans-serif", fontWeight: 600, fontSize: "0.875rem",
                  cursor: "pointer", transition: "all 0.2s",
                }}
              >
                {cat}
              </button>
            ))}
          </div>

          {loading ? (
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(280px, 1fr))", gap: "1.5rem" }}>
              {[...Array(8)].map((_, i) => (
                <div key={i} style={{ height: 340, background: "#F5F5F5", borderRadius: 20 }} />
              ))}
            </div>
          ) : activities.length > 0 ? (
            <>
              <p style={{ color: "#757575", marginBottom: "1.5rem", fontSize: "0.9rem" }}>
                {activities.length} {activities.length === 1 ? "actividad encontrada" : "actividades encontradas"}
              </p>
              <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(280px, 1fr))", gap: "1.5rem" }}>
                {activities.map(a => <ActivityCard key={a.id} activity={a} />)}
              </div>
            </>
          ) : (
            <div style={{ textAlign: "center", padding: "5rem", color: "#757575" }}>
              <p style={{ fontSize: "1.1rem" }}>No se encontraron actividades.</p>
            </div>
          )}
        </div>
      </section>
    </>
  );
}
