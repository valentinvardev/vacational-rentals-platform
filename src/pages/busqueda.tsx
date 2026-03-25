import Head from "next/head";
import { useRouter } from "next/router";
import { useEffect, useState } from "react";
import { Search, SlidersHorizontal, X, Map } from "lucide-react";
import Link from "next/link";
import PropertyCard, { type Property } from "~/components/PropertyCard";

interface Filters {
  q: string;
  min_price: string;
  max_price: string;
  beds: string;
  guests: string;
}

export default function BusquedaPage() {
  const router = useRouter();
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading] = useState(true);
  const [showFilters, setShowFilters] = useState(false);
  const [filters, setFilters] = useState<Filters>({ q: "", min_price: "", max_price: "", beds: "", guests: "" });
  const [page, setPage] = useState(1);
  const [total, setTotal] = useState(0);
  const PER_PAGE = 12;

  useEffect(() => {
    if (!router.isReady) return;
    setFilters(f => ({ ...f, q: (router.query.q as string) ?? "" }));
  }, [router.isReady, router.query.q]);

  useEffect(() => {
    const params = new URLSearchParams();
    if (filters.q) params.set("search", filters.q);
    if (filters.min_price) params.set("min_price", filters.min_price);
    if (filters.max_price) params.set("max_price", filters.max_price);
    if (filters.beds) params.set("beds", filters.beds);
    if (filters.guests) params.set("guests", filters.guests);
    params.set("page", String(page));
    params.set("per_page", String(PER_PAGE));

    setLoading(true);
    fetch(`/api/properties?${params.toString()}`)
      .then(r => r.json())
      .then((data: { data?: Property[]; total?: number } | Property[]) => {
        if (Array.isArray(data)) {
          setProperties(data);
          setTotal(data.length);
        } else {
          setProperties((data as { data?: Property[] }).data ?? []);
          setTotal((data as { total?: number }).total ?? 0);
        }
      })
      .catch(() => setProperties([]))
      .finally(() => setLoading(false));
  }, [filters, page]);

  const setFilter = (key: keyof Filters, value: string) => {
    setFilters(f => ({ ...f, [key]: value }));
    setPage(1);
  };

  const clearFilters = () => {
    setFilters({ q: "", min_price: "", max_price: "", beds: "", guests: "" });
    setPage(1);
  };

  const totalPages = Math.ceil(total / PER_PAGE);

  return (
    <>
      <Head>
        <title>Buscar Hospedajes en Villa Carlos Paz - RentaTurista</title>
        <meta name="description" content="Buscá y filtrá hospedajes en Villa Carlos Paz según tus necesidades." />
      </Head>

      {/* Search header */}
      <section style={{ background: "#FAFAFA", padding: "2.5rem clamp(1.5rem, 5vw, 4rem)", borderBottom: "1px solid #EEEEEE" }}>
        <div style={{ maxWidth: 1400, margin: "0 auto" }}>
          <h1 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.5rem, 3vw, 2rem)", color: "#212121", marginBottom: "1.25rem" }}>
            Buscar hospedajes
          </h1>
          <div style={{ display: "flex", gap: "0.75rem", flexWrap: "wrap" }}>
            {/* Search input */}
            <div style={{
              display: "flex", gap: "0.5rem", flex: "1 1 300px",
              background: "#fff", borderRadius: 14, padding: "0.75rem 1rem",
              border: "1px solid #E0E0E0", alignItems: "center",
            }}>
              <Search size={18} style={{ color: "#757575" }} />
              <input
                type="text"
                placeholder="Buscar por nombre o dirección..."
                value={filters.q}
                onChange={e => setFilter("q", e.target.value)}
                style={{ flex: 1, border: "none", outline: "none", fontFamily: "Poppins, sans-serif", fontSize: "0.9rem", background: "transparent" }}
              />
              {filters.q && <button onClick={() => setFilter("q", "")} style={{ background: "none", border: "none", cursor: "pointer", color: "#757575" }}><X size={16} /></button>}
            </div>

            <button
              onClick={() => setShowFilters(!showFilters)}
              style={{
                display: "flex", alignItems: "center", gap: "0.5rem",
                padding: "0.75rem 1.25rem", background: showFilters ? "#FF6B35" : "#fff",
                color: showFilters ? "#fff" : "#212121", border: `1px solid ${showFilters ? "#FF6B35" : "#E0E0E0"}`,
                borderRadius: 14, fontFamily: "Poppins, sans-serif", fontWeight: 600,
                fontSize: "0.9rem", cursor: "pointer",
              }}
            >
              <SlidersHorizontal size={17} /> Filtros
            </button>

            <Link href="/mapa" style={{
              display: "flex", alignItems: "center", gap: "0.5rem",
              padding: "0.75rem 1.25rem", background: "#fff", color: "#212121",
              border: "1px solid #E0E0E0", borderRadius: 14, textDecoration: "none",
              fontFamily: "Poppins, sans-serif", fontWeight: 600, fontSize: "0.9rem",
            }}>
              <Map size={17} /> Ver mapa
            </Link>
          </div>

          {/* Filters panel */}
          {showFilters && (
            <div style={{ marginTop: "1rem", padding: "1.5rem", background: "#fff", borderRadius: 16, border: "1px solid #EEEEEE", display: "flex", gap: "1.5rem", flexWrap: "wrap", alignItems: "flex-end" }}>
              {[
                { label: "Precio mín.", key: "min_price" as keyof Filters, placeholder: "$0", type: "number" },
                { label: "Precio máx.", key: "max_price" as keyof Filters, placeholder: "$100.000", type: "number" },
                { label: "Habitaciones", key: "beds" as keyof Filters, placeholder: "Cualquiera", type: "number" },
                { label: "Huéspedes", key: "guests" as keyof Filters, placeholder: "Cualquiera", type: "number" },
              ].map(({ label, key, placeholder, type }) => (
                <div key={key} style={{ display: "flex", flexDirection: "column", gap: "0.375rem", minWidth: 140 }}>
                  <label style={{ fontSize: "0.8rem", fontWeight: 600, color: "#757575", fontFamily: "Poppins, sans-serif" }}>{label}</label>
                  <input
                    type={type}
                    placeholder={placeholder}
                    value={filters[key]}
                    onChange={e => setFilter(key, e.target.value)}
                    style={{ padding: "0.625rem 0.875rem", border: "1px solid #E0E0E0", borderRadius: 10, fontFamily: "Poppins, sans-serif", fontSize: "0.9rem", outline: "none" }}
                  />
                </div>
              ))}
              <button onClick={clearFilters} style={{ display: "flex", alignItems: "center", gap: "0.4rem", padding: "0.625rem 1rem", background: "none", border: "1px solid #E0E0E0", borderRadius: 10, cursor: "pointer", color: "#757575", fontSize: "0.85rem", fontFamily: "Poppins, sans-serif" }}>
                <X size={14} /> Limpiar
              </button>
            </div>
          )}
        </div>
      </section>

      {/* Results */}
      <section style={{ padding: "2.5rem clamp(1.5rem, 5vw, 4rem)" }}>
        <div style={{ maxWidth: 1400, margin: "0 auto" }}>
          {!loading && (
            <p style={{ color: "#757575", marginBottom: "1.5rem", fontSize: "0.9rem" }}>
              {total} {total === 1 ? "resultado" : "resultados"}
            </p>
          )}

          {loading ? (
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(300px, 1fr))", gap: "1.5rem" }}>
              {[...Array(8)].map((_, i) => (
                <div key={i} style={{ height: 380, background: "#F5F5F5", borderRadius: 20 }} />
              ))}
            </div>
          ) : properties.length > 0 ? (
            <>
              <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(300px, 1fr))", gap: "1.5rem" }}>
                {properties.map(p => <PropertyCard key={p.id} property={p} />)}
              </div>

              {/* Pagination */}
              {totalPages > 1 && (
                <div style={{ display: "flex", justifyContent: "center", gap: "0.5rem", marginTop: "3rem", flexWrap: "wrap" }}>
                  {[...Array(totalPages)].map((_, i) => (
                    <button
                      key={i}
                      onClick={() => setPage(i + 1)}
                      style={{
                        width: 40, height: 40, borderRadius: "50%", border: "2px solid",
                        borderColor: page === i + 1 ? "#FF6B35" : "#E0E0E0",
                        background: page === i + 1 ? "#FF6B35" : "#fff",
                        color: page === i + 1 ? "#fff" : "#424242",
                        fontFamily: "Poppins, sans-serif", fontWeight: 600, cursor: "pointer",
                      }}
                    >
                      {i + 1}
                    </button>
                  ))}
                </div>
              )}
            </>
          ) : (
            <div style={{ textAlign: "center", padding: "5rem", color: "#757575" }}>
              <p style={{ fontSize: "1.1rem", marginBottom: "1rem" }}>No se encontraron hospedajes con esos filtros.</p>
              <button onClick={clearFilters} style={{ color: "#FF6B35", background: "none", border: "none", cursor: "pointer", fontWeight: 600, fontSize: "1rem" }}>
                Limpiar filtros
              </button>
            </div>
          )}
        </div>
      </section>
    </>
  );
}
