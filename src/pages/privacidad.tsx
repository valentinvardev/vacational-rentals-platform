import Head from "next/head";
import Link from "next/link";
import { ArrowLeft } from "lucide-react";

export default function PrivacidadPage() {
  return (
    <>
      <Head>
        <title>Política de Privacidad - RentaTurista</title>
      </Head>

      <div style={{ maxWidth: 900, margin: "0 auto", padding: "3rem clamp(1.5rem, 5vw, 4rem)" }}>
        <Link href="/" style={{ display: "inline-flex", alignItems: "center", gap: "0.4rem", color: "#757575", textDecoration: "none", marginBottom: "2rem", fontFamily: "Poppins, sans-serif", fontSize: "0.9rem" }}>
          <ArrowLeft size={16} /> Volver al inicio
        </Link>

        <h1 style={{ fontFamily: "Poppins, sans-serif", fontWeight: 800, fontSize: "clamp(1.75rem, 3vw, 2.5rem)", color: "#212121", marginBottom: "0.5rem" }}>
          Política de Privacidad
        </h1>
        <p style={{ color: "#757575", fontSize: "0.9rem", marginBottom: "3rem" }}>Última actualización: enero 2025</p>

        {[
          {
            title: "1. Introducción",
            content: "RentaTurista se compromete a proteger la privacidad de sus usuarios. Esta política describe cómo recopilamos, usamos y protegemos tu información personal cuando utilizás nuestra plataforma de alquileres vacacionales en Villa Carlos Paz.",
          },
          {
            title: "2. Información que recopilamos",
            content: "Recopilamos información que vos nos proporcionás directamente (nombre, email, teléfono), información de uso de la plataforma (páginas visitadas, búsquedas realizadas), y datos técnicos (dirección IP, tipo de dispositivo, navegador).",
          },
          {
            title: "3. Uso de la información",
            content: "Usamos tu información para: brindarte los servicios de la plataforma, personalizar tu experiencia de búsqueda, enviarte comunicaciones relevantes (con tu consentimiento), mejorar nuestros servicios, y cumplir con obligaciones legales.",
          },
          {
            title: "4. Protección de tus datos",
            content: "Implementamos medidas de seguridad técnicas y organizativas para proteger tu información. Tus datos se almacenan en servidores seguros y solo el personal autorizado tiene acceso a ellos.",
          },
          {
            title: "5. Compartir información",
            content: "No vendemos ni alquilamos tu información personal a terceros. Solo compartimos datos cuando es necesario para prestar el servicio (ej. comunicarte con propietarios) o cuando lo requiera la ley.",
          },
          {
            title: "6. Cookies",
            content: "Utilizamos cookies para mejorar la funcionalidad del sitio y personalizar tu experiencia. Podés configurar tu navegador para rechazar cookies, aunque esto puede afectar el funcionamiento de algunas funciones.",
          },
          {
            title: "7. Tus derechos",
            content: "Tenés derecho a acceder, rectificar y eliminar tus datos personales. Para ejercer estos derechos, contactanos a través de hola@rentaturista.com.",
          },
          {
            title: "8. Contacto",
            content: "Si tenés preguntas sobre esta política, podés contactarnos en: hola@rentaturista.com | Villa Carlos Paz, Córdoba, Argentina.",
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
