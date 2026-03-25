import { useEffect, useState } from "react";
import { ArrowUp } from "lucide-react";

export default function BackToTop() {
  const [visible, setVisible] = useState(false);

  useEffect(() => {
    const onScroll = () => setVisible(window.scrollY > 500);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <button
      onClick={() => window.scrollTo({ top: 0, behavior: "smooth" })}
      aria-label="Volver arriba"
      style={{
        position: "fixed",
        bottom: "6rem",
        right: "2rem",
        width: 48,
        height: 48,
        background: "#FF6B35",
        color: "#fff",
        border: "none",
        borderRadius: "50%",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        boxShadow: "0 4px 12px rgba(255,107,53,0.3)",
        cursor: "pointer",
        zIndex: 998,
        transition: "all 0.3s cubic-bezier(0.4,0,0.2,1)",
        opacity: visible ? 1 : 0,
        visibility: visible ? "visible" : "hidden",
        transform: visible ? "translateY(0)" : "translateY(20px)",
      }}
      onMouseEnter={e => {
        (e.currentTarget as HTMLElement).style.background = "#E55527";
        (e.currentTarget as HTMLElement).style.transform = "translateY(-3px)";
      }}
      onMouseLeave={e => {
        (e.currentTarget as HTMLElement).style.background = "#FF6B35";
        (e.currentTarget as HTMLElement).style.transform = visible ? "translateY(0)" : "translateY(20px)";
      }}
    >
      <ArrowUp size={22} />
    </button>
  );
}
