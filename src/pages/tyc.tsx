import Head from "next/head";
import Link from "next/link";
import { ArrowLeft } from "lucide-react";

const SECTIONS = [
  { title: "1. Aceptación de los términos", body: "Al acceder y usar RentaTurista, aceptás estos términos y condiciones en su totalidad. Si no estás de acuerdo con alguna parte, no podrás usar nuestros servicios." },
  { title: "2. Descripción del servicio", body: "RentaTurista es una plataforma de alquileres vacacionales que conecta a turistas con propietarios en Villa Carlos Paz, Córdoba, Argentina. Actuamos como intermediarios y no somos propietarios de los inmuebles listados." },
  { title: "3. Registro y cuenta", body: "Para acceder a ciertas funciones, podés necesitar crear una cuenta. Sos responsable de mantener la confidencialidad de tus credenciales y de todas las actividades que ocurran bajo tu cuenta." },
  { title: "4. Reservas y pagos", body: "Las reservas se gestionan directamente entre el huésped y el propietario. RentaTurista no procesa pagos directamente. Los términos específicos son acordados entre las partes involucradas." },
  { title: "5. Responsabilidades del propietario", body: "Los propietarios son responsables de la exactitud de la información publicada, el mantenimiento del alojamiento, el cumplimiento de la normativa local y brindar un servicio de calidad." },
  { title: "6. Responsabilidades del huésped", body: "Los huéspedes se comprometen a respetar las normas de la propiedad, comunicar cualquier daño y cumplir con los horarios de check-in y check-out acordados." },
  { title: "7. Limitación de responsabilidad", body: "RentaTurista no se hace responsable por daños directos, indirectos o incidentales que resulten del uso de la plataforma o de las estadías en propiedades listadas." },
  { title: "8. Modificaciones", body: "Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entran en vigencia al ser publicados. El uso continuado implica la aceptación de los términos modificados." },
  { title: "9. Contacto", body: "Para consultas: hola@rentaturista.com | Villa Carlos Paz, Córdoba, Argentina." },
];

export default function TyCPage() {
  return (
    <>
      <Head><title>Términos y Condiciones — RentaTurista</title></Head>

      <div style={{ background: "var(--white)", paddingTop: "var(--header-height)" }}>
        <div className="legal-page">
          <Link href="/" className="back-btn"><ArrowLeft size={15} /> Volver al inicio</Link>
          <h1>Términos y Condiciones</h1>
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
