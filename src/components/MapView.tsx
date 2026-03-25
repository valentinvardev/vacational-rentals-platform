"use client";
import { useEffect } from "react";
import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";
import L from "leaflet";
import Link from "next/link";
import type { Property } from "./PropertyCard";

// Fix Leaflet default icon paths broken by webpack
delete (L.Icon.Default.prototype as unknown as Record<string, unknown>)._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png",
  iconUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png",
  shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
});

const orangeIcon = new L.Icon({
  iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png",
  shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41],
});

interface MapViewProps {
  properties: Property[];
}

export default function MapView({ properties }: MapViewProps) {
  const hasCoords = properties.filter(p => (p as unknown as { latitude?: number }).latitude && (p as unknown as { longitude?: number }).longitude);

  return (
    <>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
      <MapContainer
        center={[-31.4135, -64.4945]}
        zoom={13}
        style={{ height: "100%", width: "100%" }}
        zoomControl={true}
      >
        <TileLayer
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />
        {hasCoords.map(p => {
          const pd = p as unknown as { latitude: number; longitude: number };
          return (
            <Marker key={p.id} position={[pd.latitude, pd.longitude]} icon={orangeIcon}>
              <Popup>
                <div style={{ fontFamily: "Poppins, sans-serif", minWidth: 180 }}>
                  <strong style={{ fontSize: "0.9rem", display: "block", marginBottom: "0.3rem" }}>{p.title}</strong>
                  <p style={{ fontSize: "0.8rem", color: "#757575", marginBottom: "0.5rem" }}>{p.address}</p>
                  <p style={{ fontWeight: 700, color: "#FF6B35", marginBottom: "0.5rem" }}>${p.price.toLocaleString("es-AR")}/noche</p>
                  <a href={`/propiedad/${p.id}`} style={{ color: "#FF6B35", fontSize: "0.85rem", fontWeight: 600 }}>Ver propiedad →</a>
                </div>
              </Popup>
            </Marker>
          );
        })}
      </MapContainer>
    </>
  );
}
