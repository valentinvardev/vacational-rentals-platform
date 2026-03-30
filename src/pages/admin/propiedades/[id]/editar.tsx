import type { ReactNode } from "react";
import { useEffect, useState } from "react";
import { useRouter } from "next/router";
import PropertyForm, { type PropertyFormData } from "~/components/PropertyForm";
import { withAdminLayout } from "~/components/AdminLayout";

interface FullProperty {
  id: number; title: string; description?: string; address: string;
  price: number; beds: number; baths: number; guests: number;
  rating?: number; type_name?: string; status: string; lat?: number; lng?: number;
  amenities: { name: string; icon?: string }[];
  images: { url: string; is_primary: boolean }[];
}

export default function EditarPropiedad() {
  const router = useRouter();
  const { id } = router.query;
  const [property, setProperty] = useState<FullProperty | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!id) return;
    fetch(`/api/admin/properties/${id as string}`)
      .then(r => r.json())
      .then((d: FullProperty) => setProperty(d))
      .catch(console.error)
      .finally(() => setLoading(false));
  }, [id]);

  const handleSubmit = async (data: PropertyFormData) => {
    const res = await fetch(`/api/admin/properties/${id as string}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!res.ok) {
      const err = await res.json() as { error?: string };
      throw new Error(err.error ?? "Error al guardar");
    }
    void router.push("/admin/propiedades");
  };

  if (loading) return (
    <div style={{ display: "flex", alignItems: "center", justifyContent: "center", minHeight: "40vh" }}>
      <div className="spinner" />
    </div>
  );

  if (!property) return (
    <div className="empty-state">
      <div className="empty-state-icon">🔍</div>
      <h3>Propiedad no encontrada</h3>
    </div>
  );

  return (
    <PropertyForm
      mode="edit"
      initial={{
        title: property.title,
        description: property.description ?? "",
        type_name: property.type_name ?? "",
        address: property.address,
        beds: String(property.beds),
        baths: String(property.baths),
        guests: String(property.guests),
        price: String(property.price),
        rating: property.rating != null ? String(property.rating) : "",
        status: property.status,
        lat: property.lat != null ? String(property.lat) : "",
        lng: property.lng != null ? String(property.lng) : "",
        amenities: property.amenities.map(a => ({ name: a.name, icon: a.icon ?? "" })),
        images: property.images.length > 0 ? property.images : [{ url: "", is_primary: true }],
      }}
      onSubmit={handleSubmit}
    />
  );
}

EditarPropiedad.getLayout = (page: ReactNode) => withAdminLayout("Editar Propiedad")(page);
