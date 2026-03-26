import Head from "next/head";
import { useRouter } from "next/router";
import { useEffect, useState } from "react";
import { Search, SlidersHorizontal, X, Map } from "lucide-react";
import Link from "next/link";
import PropertyCard, { type Property } from "~/components/PropertyCard";

interface Filters { q: string; min_price: string; max_price: string; beds: string; guests: string; }

const PER_PAGE = 12;

export default function BusquedaPage() {
  const router = useRouter();
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading]       = useState(true);
  const [showFilters, setShowFilters] = useState(false);
  const [filters, setFilters] = useState<Filters>({ q: "", min_price: "", max_price: "", beds: "", guests: "" });
  const [page, setPage]   = useState(1);
  const [total, setTotal] = useState(0);

  useEffect(() => {
    if (!router.isReady) return;
    setFilters(f => ({ ...f, q: (router.query.q as string) ?? "" }));
  }, [router.isReady, router.query.q]);

  useEffect(() => {
    const p = new URLSearchParams();
    if (filters.q)         p.set("search", filters.q);
    if (filters.min_price) p.set("min_price", filters.min_price);
    if (filters.max_price) p.set("max_price", filters.max_price);
    if (filters.beds)      p.set("beds", filters.beds);
    if (filters.guests)    p.set("guests", filters.guests);
    p.set("page", String(page));
    p.set("per_page", String(PER_PAGE));

    setLoading(true);
    fetch(`/api/properties?${p.toString()}`)
      .then(r => r.json())
      .then((d: { data?: Property[]; total?: number } | Property[]) => {
        if (Array.isArray(d)) { setProperties(d); setTotal(d.length); }
        else { setProperties((d as { data?: Property[] }).data ?? []); setTotal((d as { total?: number }).total ?? 0); }
      })
      .catch(() => setProperties([]))
      .finally(() => setLoading(false));
  }, [filters, page]);

  const setFilter = (k: keyof Filters, v: string) => { setFilters(f => ({ ...f, [k]: v })); setPage(1); };
  const clearFilters = () => { setFilters({ q: "", min_price: "", max_price: "", beds: "", guests: "" }); setPage(1); };

  const totalPages = Math.ceil(total / PER_PAGE);

  return (
    <>
      <Head>
        <title>Buscar Hospedajes — Villa Carlos Paz | RentaTurista</title>
        <meta name="description" content="Buscá y filtrá hospedajes en Villa Carlos Paz." />
      </Head>

      <div className="page-wrapper">
        <div className="container" style={{ paddingTop: "2.5rem", paddingBottom: "4rem" }}>

          {/* Header */}
          <div className="page-header">
            <div>
              <h1 className="page-title">Buscar alojamientos</h1>
              <p className="page-subtitle">Encontrá el hospedaje ideal para tu estadía</p>
            </div>
            <Link href="/mapa" className="btn btn-outline btn-sm">
              <Map size={16} /> Ver en mapa
            </Link>
          </div>

          {/* Search bar */}
          <div className="search-bar-wrapper">
            <div style={{ display: "grid", gridTemplateColumns: "1fr auto auto", gap: "1rem", alignItems: "end" }}>
              <div className="search-field">
                <label className="search-label">Buscar</label>
                <div className="search-input-icon">
                  <Search size={17} className="icon" />
                  <input
                    type="text"
                    className="search-input"
                    placeholder="Nombre, zona o tipo de hospedaje…"
                    value={filters.q}
                    onChange={e => setFilter("q", e.target.value)}
                    style={{ paddingLeft: "2.75rem" }}
                  />
                </div>
              </div>
              <button
                className={`btn btn-sm ${showFilters ? "btn-primary" : "btn-ghost"}`}
                onClick={() => setShowFilters(s => !s)}
              >
                <SlidersHorizontal size={15} /> Filtros
              </button>
              {(filters.q || filters.min_price || filters.max_price || filters.beds || filters.guests) && (
                <button className="btn btn-sm btn-ghost" onClick={clearFilters}>
                  <X size={15} /> Limpiar
                </button>
              )}
            </div>

            {/* Filter panel */}
            {showFilters && (
              <div style={{ marginTop: "1.25rem", paddingTop: "1.25rem", borderTop: "1px solid var(--gray-200)", display: "flex", gap: "1.25rem", flexWrap: "wrap", alignItems: "flex-end" }}>
                {([
                  { label: "Precio mín.", key: "min_price", placeholder: "$0" },
                  { label: "Precio máx.", key: "max_price", placeholder: "$100.000" },
                  { label: "Habitaciones", key: "beds",      placeholder: "Cualquiera" },
                  { label: "Huéspedes",   key: "guests",    placeholder: "Cualquiera" },
                ] as { label: string; key: keyof Filters; placeholder: string }[]).map(({ label, key, placeholder }) => (
                  <div key={key} className="search-field" style={{ minWidth: 140 }}>
                    <label className="search-label">{label}</label>
                    <input
                      type="number"
                      className="search-input"
                      placeholder={placeholder}
                      value={filters[key]}
                      onChange={e => setFilter(key, e.target.value)}
                    />
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* Results */}
          {!loading && (
            <p className="results-count">
              <strong>{total}</strong> {total === 1 ? "resultado" : "resultados"}
            </p>
          )}

          {loading ? (
            <div className="cards-grid">
              {[...Array(8)].map((_, i) => <div key={i} className="skeleton" style={{ height: 380 }} />)}
            </div>
          ) : properties.length > 0 ? (
            <>
              <div className="cards-grid">
                {properties.map(p => <PropertyCard key={p.id} property={p} />)}
              </div>
              {totalPages > 1 && (
                <div className="pagination">
                  {[...Array(totalPages)].map((_, i) => (
                    <button key={i} className={`page-btn${page === i + 1 ? " active" : ""}`} onClick={() => setPage(i + 1)}>
                      {i + 1}
                    </button>
                  ))}
                </div>
              )}
            </>
          ) : (
            <div className="empty-state">
              <div className="empty-state-icon">🔍</div>
              <h3>Sin resultados</h3>
              <p>Intentá con otros filtros o&nbsp;
                <button onClick={clearFilters} style={{ color: "var(--orange-primary)", background: "none", border: "none", fontWeight: 600, cursor: "pointer" }}>
                  limpiá los filtros
                </button>
              </p>
            </div>
          )}
        </div>
      </div>
    </>
  );
}
