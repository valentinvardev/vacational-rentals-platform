import Head from "next/head";
import { useEffect, useState } from "react";
import { Search, Map } from "lucide-react";
import Link from "next/link";
import ActivityCard, { type Activity } from "~/components/ActivityCard";

const CATS = ["Todos", "Restaurante", "Teatro", "Parque", "Museo", "Aventura", "Playa"];

export default function ActividadesPage() {
  const [activities, setActivities] = useState<Activity[]>([]);
  const [loading, setLoading]       = useState(true);
  const [search, setSearch]         = useState("");
  const [category, setCategory]     = useState("Todos");

  useEffect(() => {
    const p = new URLSearchParams();
    if (search) p.set("search", search);
    if (category !== "Todos") p.set("category", category.toLowerCase());

    setLoading(true);
    fetch(`/api/places?${p.toString()}`)
      .then(r => r.json())
      .then((d: { data?: Activity[] } | Activity[]) => {
        setActivities(Array.isArray(d) ? d : ((d as { data?: Activity[] }).data ?? []));
      })
      .catch(() => setActivities([]))
      .finally(() => setLoading(false));
  }, [search, category]);

  return (
    <>
      <Head>
        <title>Actividades en Villa Carlos Paz — RentaTurista</title>
        <meta name="description" content="Descubrí los mejores lugares y actividades en Villa Carlos Paz: restaurantes, teatros, parques y más." />
      </Head>

      <div className="page-wrapper">
        <div className="container" style={{ paddingTop: "2.5rem", paddingBottom: "4rem" }}>

          {/* Header */}
          <div className="page-header">
            <div>
              <h1 className="page-title">Actividades y lugares</h1>
              <p className="page-subtitle">Todo lo que podés hacer en Villa Carlos Paz</p>
            </div>
            <Link href="/mapa" className="btn btn-outline btn-sm">
              <Map size={16} /> Ver en mapa
            </Link>
          </div>

          {/* Search */}
          <div className="search-bar-wrapper">
            <div className="search-input-icon">
              <Search size={17} className="icon" />
              <input
                type="text"
                className="search-input"
                placeholder="Buscar actividades y lugares…"
                value={search}
                onChange={e => setSearch(e.target.value)}
                style={{ paddingLeft: "2.75rem" }}
              />
            </div>
          </div>

          {/* Category pills */}
          <div className="filter-pills">
            {CATS.map(cat => (
              <button
                key={cat}
                className={`filter-pill${category === cat ? " active" : ""}`}
                onClick={() => setCategory(cat)}
              >
                {cat}
              </button>
            ))}
          </div>

          {/* Results */}
          {!loading && (
            <p className="results-count">
              <strong>{activities.length}</strong> {activities.length === 1 ? "actividad encontrada" : "actividades encontradas"}
            </p>
          )}

          {loading ? (
            <div className="cards-grid">
              {[...Array(8)].map((_, i) => <div key={i} className="skeleton" style={{ height: 320 }} />)}
            </div>
          ) : activities.length > 0 ? (
            <div className="cards-grid">
              {activities.map(a => <ActivityCard key={a.id} activity={a} />)}
            </div>
          ) : (
            <div className="empty-state">
              <div className="empty-state-icon">🎯</div>
              <h3>Sin actividades</h3>
              <p>No se encontraron actividades con esos filtros.</p>
            </div>
          )}
        </div>
      </div>
    </>
  );
}
