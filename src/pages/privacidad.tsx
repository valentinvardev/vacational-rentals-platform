import Head from "next/head";
import Link from "next/link";
import { ArrowLeft } from "lucide-react";

const SECTIONS = [
  { title: "1. Introducción", body: "RentaTurista se compromete a proteger la privacidad de sus usuarios. Esta política describe cómo recopilamos, usamos y protegemos tu información personal cuando utilizás nuestra plataforma de alquileres vacacionales en Villa Carlos Paz." },
  { title: "2. Información que recopilamos", body: "Recopilamos información que vos nos proporcionás directamente (nombre, email, teléfono), información de uso de la plataforma (páginas visitadas, búsquedas realizadas), y datos técnicos (dirección IP, tipo de dispositivo, navegador)." },
  { title: "3. Uso de la información", body: "Usamos tu información para: brindarte los servicios de la plataforma, personalizar tu experiencia de búsqueda, enviarte comunicaciones relevantes (con tu consentimiento), mejorar nuestros servicios, y cumplir con obligaciones legales." },
  { title: "4. Protección de tus datos", body: "Implementamos medidas de seguridad técnicas y organizativas para proteger tu información. Tus datos se almacenan en servidores seguros y solo el personal autorizado tiene acceso a ellos." },
  { title: "5. Compartir información", body: "No vendemos ni alquilamos tu información personal a terceros. Solo compartimos datos cuando es necesario para prestar el servicio o cuando lo requiera la ley." },
  { title: "6. Cookies", body: "Utilizamos cookies para mejorar la funcionalidad del sitio y personalizar tu experiencia. Podés configurar tu navegador para rechazarlas, aunque esto puede afectar algunas funciones." },
  { title: "7. Tus derechos", body: "Tenés derecho a acceder, rectificar y eliminar tus datos personales. Para ejercer estos derechos, contactanos a través de hola@rentaturista.com." },
  { title: "8. Contacto", body: "Si tenés preguntas sobre esta política, podés contactarnos en: hola@rentaturista.com | Villa Carlos Paz, Córdoba, Argentina." },
];

export default function PrivacidadPage() {
  return (
    <>
      <Head><title>Política de Privacidad — RentaTurista</title></Head>

      <div style={{ background: "var(--white)", paddingTop: "var(--header-height)" }}>
        <div className="legal-page">
          <Link href="/" className="back-btn"><ArrowLeft size={15} /> Volver al inicio</Link>
          <h1>Política de Privacidad</h1>
          <p className="legal-date">Última actualización: enero 2025</p>
          {SECTIONS.map(({ title, body }) => (
            <div key={title} className="legal-section">
              <h2>{title}</h2>
              <p>{body}</p>
            </div>
          ))}
        </div>
      </div>
    </>
  );
}
