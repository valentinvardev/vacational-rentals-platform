import { PrismaClient } from "../generated/prisma";

const db = new PrismaClient();

const properties = [
  {
    title: "Cabaña en el Bosque — San Marcos Sierras",
    description:
      "Hermosa cabaña de madera rodeada de naturaleza, a pasos del río. Ideal para desconectarse: sin televisión, con hamaca paraguaya y fogón exterior. Perfecta para parejas o familias pequeñas que buscan paz y contacto con la naturaleza cordobesa.",
    address: "Camino al Río s/n, San Marcos Sierras, Córdoba",
    price: 18000,
    beds: 2,
    baths: 1,
    guests: 4,
    rating: 4.8,
    reviews_count: 24,
    type_name: "Cabaña",
    images: [
      { url: "https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=800&q=80", is_primary: true },
      { url: "https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=800&q=80", is_primary: false },
      { url: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80", is_primary: false },
    ],
    amenities: [
      { name: "Wi-Fi", icon: "wifi" },
      { name: "Estacionamiento", icon: "parking" },
      { name: "Aire acondicionado", icon: "ac" },
      { name: "Desayuno incluido", icon: "breakfast" },
    ],
    reviews: [
      { author: "Mariana G.", rating: 5, text: "Un lugar mágico. El silencio, el río, la cabaña... todo perfecto. Ya queremos volver." },
      { author: "Lucas P.", rating: 5, text: "Muy tranquilo y cómodo. Los dueños son muy amables y atentos." },
      { author: "Sofía R.", rating: 4, text: "Hermoso lugar, el único detalle es que el camino de acceso es un poco difícil con auto bajo." },
    ],
  },
  {
    title: "Departamento céntrico con vista al mar — Mar del Plata",
    description:
      "Moderno departamento de 2 ambientes a 100 metros de Playa Grande. Totalmente equipado, con balcón y vista parcial al mar. A pasos de los mejores restaurantes y del centro comercial. Ideal para escapadas de fin de semana o vacaciones de verano.",
    address: "Av. Colón 2250, Mar del Plata, Buenos Aires",
    price: 22000,
    beds: 1,
    baths: 1,
    guests: 3,
    rating: 4.6,
    reviews_count: 41,
    type_name: "Departamento",
    images: [
      { url: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80", is_primary: true },
      { url: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80", is_primary: false },
      { url: "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80", is_primary: false },
    ],
    amenities: [
      { name: "Wi-Fi", icon: "wifi" },
      { name: "Smart TV", icon: "tv" },
      { name: "Aire acondicionado", icon: "ac" },
      { name: "Estacionamiento", icon: "parking" },
    ],
    reviews: [
      { author: "Valentina K.", rating: 5, text: "Ubicación inmejorable. El departamento está impecable y tiene todo lo necesario." },
      { author: "Andrés M.", rating: 4, text: "Muy cómodo y bien ubicado. La vista al mar desde el balcón es hermosa." },
      { author: "Carolina B.", rating: 5, text: "Todo excelente. Ya lo reservé para el próximo verano también." },
    ],
  },
  {
    title: "Casa con pileta — Villa Carlos Paz",
    description:
      "Amplia casa familiar con pileta privada, parrilla y jardín. Capacidad para hasta 8 personas. Dormitorios con aire acondicionado, cocina totalmente equipada y sala de juegos. A 10 minutos del lago San Roque y del centro de Carlos Paz.",
    address: "Los Molles 345, Villa Carlos Paz, Córdoba",
    price: 35000,
    beds: 3,
    baths: 2,
    guests: 8,
    rating: 4.9,
    reviews_count: 57,
    type_name: "Casa",
    images: [
      { url: "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80", is_primary: true },
      { url: "https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=800&q=80", is_primary: false },
      { url: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80", is_primary: false },
    ],
    amenities: [
      { name: "Wi-Fi", icon: "wifi" },
      { name: "Pileta privada", icon: "pool" },
      { name: "Estacionamiento", icon: "parking" },
      { name: "Aire acondicionado", icon: "ac" },
      { name: "Smart TV", icon: "tv" },
    ],
    reviews: [
      { author: "Familia Torres", rating: 5, text: "La pileta es increíble. Los chicos no querían irse. Todo en perfecto estado." },
      { author: "Pablo E.", rating: 5, text: "Casa enorme, cómoda y bien equipada. La parrilla es de primera." },
      { author: "Natalia F.", rating: 5, text: "Perfecta para familias numerosas. Volvimos por segundo año consecutivo." },
    ],
  },
  {
    title: "Loft de diseño en Palermo — Buenos Aires",
    description:
      "Loft minimalista en el corazón de Palermo Hollywood. Techos altos, cocina gourmet y decoración de autor. A metros de los mejores bares y restaurantes de Buenos Aires. Ideal para viajeros que buscan una experiencia urbana sofisticada.",
    address: "Thames 1780, Palermo Hollywood, CABA",
    price: 28000,
    beds: 1,
    baths: 1,
    guests: 2,
    rating: 4.7,
    reviews_count: 33,
    type_name: "Loft",
    images: [
      { url: "https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=800&q=80", is_primary: true },
      { url: "https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=80", is_primary: false },
      { url: "https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&q=80", is_primary: false },
    ],
    amenities: [
      { name: "Wi-Fi ultrarrápido", icon: "wifi" },
      { name: "Smart TV 55\"", icon: "tv" },
      { name: "Aire acondicionado", icon: "ac" },
      { name: "Desayuno incluido", icon: "breakfast" },
    ],
    reviews: [
      { author: "Renata L.", rating: 5, text: "Un departamento espectacular. La decoración y la ubicación son de otro nivel." },
      { author: "Martín O.", rating: 4, text: "Muy cómodo y con estilo. El barrio es ideal para salir a comer." },
    ],
  },
  {
    title: "Cabaña frente al lago — Bariloche",
    description:
      "Cabaña de montaña con vista directa al lago Nahuel Huapi. Chimenea a leña, jacuzzi exterior y deck privado. El lugar ideal para una escapada romántica rodeada de los Andes patagónicos. A 15 minutos del centro de Bariloche.",
    address: "Ruta 237 Km 18, San Carlos de Bariloche, Río Negro",
    price: 45000,
    beds: 2,
    baths: 2,
    guests: 4,
    rating: 5.0,
    reviews_count: 19,
    type_name: "Cabaña",
    images: [
      { url: "https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?w=800&q=80", is_primary: true },
      { url: "https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&q=80", is_primary: false },
      { url: "https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800&q=80", is_primary: false },
    ],
    amenities: [
      { name: "Wi-Fi", icon: "wifi" },
      { name: "Jacuzzi exterior", icon: "pool" },
      { name: "Estacionamiento", icon: "parking" },
      { name: "Calefacción central", icon: "ac" },
    ],
    reviews: [
      { author: "Diego y Ana", rating: 5, text: "Simplemente maravilloso. La vista al lago desde el jacuzzi es de película." },
      { author: "Florencia C.", rating: 5, text: "Nos quedamos 5 noches y no queríamos irnos. El lugar tiene una magia especial." },
      { author: "Roberto S.", rating: 5, text: "Relación precio-calidad insuperable. La cabaña supera todas las fotos." },
    ],
  },
  {
    title: "Casa histórica en el centro — Salta Capital",
    description:
      "Casona colonial restaurada a pocas cuadras de la Plaza 9 de Julio. Techos de vigas, patio interior con galería y 3 dormitorios bien equipados. Una experiencia única que combina el encanto colonial salteño con todas las comodidades modernas.",
    address: "Balcarce 478, Salta Capital, Salta",
    price: 16000,
    beds: 3,
    baths: 2,
    guests: 6,
    rating: 4.5,
    reviews_count: 28,
    type_name: "Casa",
    images: [
      { url: "https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80", is_primary: true },
      { url: "https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&q=80", is_primary: false },
    ],
    amenities: [
      { name: "Wi-Fi", icon: "wifi" },
      { name: "Estacionamiento", icon: "parking" },
      { name: "Aire acondicionado", icon: "ac" },
      { name: "Smart TV", icon: "tv" },
      { name: "Desayuno incluido", icon: "breakfast" },
    ],
    reviews: [
      { author: "Gustavo N.", rating: 5, text: "La casona tiene una historia increíble. El patio es un sueño." },
      { author: "María J.", rating: 4, text: "Muy céntrico y cómodo. La arquitectura colonial es preciosa." },
    ],
  },
];

async function main() {
  console.log("Borrando propiedades existentes...");
  await db.propertyReview.deleteMany();
  await db.propertyAmenity.deleteMany();
  await db.propertyImage.deleteMany();
  await db.property.deleteMany();

  console.log(`Creando ${properties.length} propiedades de ejemplo...`);

  for (const p of properties) {
    const { images, amenities, reviews, ...data } = p;
    await db.property.create({
      data: {
        ...data,
        images: { create: images },
        amenities: { create: amenities },
        reviews: { create: reviews },
      },
    });
    console.log(`  ✓ ${data.title}`);
  }

  console.log("Seed completado.");
}

main()
  .catch((e) => { console.error(e); process.exit(1); })
  .finally(() => db.$disconnect());
