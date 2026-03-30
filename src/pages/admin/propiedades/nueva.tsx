import type { ReactNode } from "react";
import { useRouter } from "next/router";
import PropertyForm, { type PropertyFormData } from "~/components/PropertyForm";
import { withAdminLayout } from "~/components/AdminLayout";

export default function NuevaPropiedad() {
  const router = useRouter();

  const handleSubmit = async (data: PropertyFormData) => {
    const res = await fetch("/api/admin/properties", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    if (!res.ok) {
      const err = await res.json() as { error?: string };
      throw new Error(err.error ?? "Error al crear");
    }
    void router.push("/admin/propiedades");
  };

  return <PropertyForm mode="create" onSubmit={handleSubmit} />;
}

NuevaPropiedad.getLayout = (page: ReactNode) => withAdminLayout("Nueva Propiedad")(page);
