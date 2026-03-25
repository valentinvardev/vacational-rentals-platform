import Head from "next/head";
import Link from "next/link";
import { ArrowLeft } from "lucide-react";

export default function TyCPage() {
  return (
    <>
      <Head>
        <title>Términos y Condiciones - RentaTurista</title>
      </Head>

      <div style={{ maxWidth: 900, margin: "0 auto", padding: "3rem clamp(1.5rem, 5vw, 4rem)" }}>
        <Link href="/" style={{ display: "inline-flex", alignItems: "center", gap: "0.4rem", color: "#757575", textDecoration: "none", marginBottom: "2rem", fontFamily: "Poppins, sans-serif", fontSize: "0.9rem" }}>
          <ArrowLeft size={16} /> Volver al inicio
        </Link>

        <h1 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.75rem, 3vw, 2.5rem)", color: "#212121", marginBottom: "0.5rem" }}>
          Términos y Condiciones
        </h1>
        <p style={{ color: "#757575", fontSize: "0.9rem", marginBottom: "3rem" }}>Última actualización: enero 2025</p>

        {[
          {
            title: "1. Aceptación de los términos",
            content: "Al acceder y usar RentaTurista, aceptás estos términos y condiciones en su totalidad. Si no estás de acuerdo con alguna parte de estos términos, no podrás usar nuestros servicios.",
          },
          {
            title: "2. Descripción del servicio",
            content: "RentaTurista es una plataforma de alquileres vacacionales que conecta a turistas con propietarios de alojamientos en Villa Carlos Paz, Córdoba, Argentina. Actuamos como intermediarios y no somos propietarios de los inmuebles listados.",
          },
          {
            title: "3. Registro y cuenta",
            content: "Para acceder a ciertas funciones, podés necesitar crear una cuenta. Sos responsable de mantener la confidencialidad de tus credenciales y de todas las actividades que ocurran bajo tu cuenta.",
          },
          {
            title: "4. Reservas y pagos",
            content: "Las reservas se gestionan directamente entre el huésped y el propietario. RentaTurista no procesa pagos directamente. Los términos específicos de cada reserva (precio, fechas, política de cancelación) son acordados entre las partes involucradas.",
          },
          {
            title: "5. Responsabilidades del propietario",
            content: "Los propietarios son responsables de la exactitud de la información publicada, del mantenimiento del alojamiento, del cumplimiento de la normativa local y de brindar un servicio de calidad a los huéspedes.",
          },
          {
            title: "6. Responsabilidades del huésped",
            content: "Los huéspedes se comprometen a respetar las normas de la propiedad, comunicar cualquier daño ocurrido durante su estadía y cumplir con los horarios de check-in y check-out acordados.",
          },
          {
            title: "7. Limitación de responsabilidad",
            content: "RentaTurista no se hace responsable por daños directos, indirectos o incidentales que resulten del uso de la plataforma o de las estadías en propiedades listadas.",
          },
          {
            title: "8. Modificaciones",
            content: "Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entran en vigencia al ser publicados en el sitio. El uso continuado de la plataforma implica la aceptación de los términos modificados.",
          },
          {
            title: "9. Contacto",
            content: "Para consultas sobre estos términos, contactanos en: hola@rentaturista.com | Villa Carlos Paz, Córdoba, Argentina.",
          },
        ].map(({ title, content }) => (
          <section key={title} style={{ marginBottom: "2.5rem" }}>
            <h2 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 700, fontSize: "1.2rem", color: "#212121", marginBottom: "0.875rem" }}>{title}</h2>
            <p style={{ fontSize: "0.975rem", color: "#757575", lineHeight: 1.8 }}>{content}</p>
          </section>
        ))}
      </div>
    </>
  );
}
