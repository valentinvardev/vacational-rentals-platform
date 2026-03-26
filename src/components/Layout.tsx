import type { ReactNode } from "react";
import Header from "./Header";
import Footer from "./Footer";
import WhatsAppButton from "./WhatsAppButton";
import BackToTop from "./BackToTop";

export default function Layout({ children }: { children: ReactNode }) {
  return (
    <>
      <Header />
      <main style={{ minHeight: "100vh" }}>
        {children}
      </main>
      <Footer />
      <WhatsAppButton />
      <BackToTop />
    </>
  );
}
