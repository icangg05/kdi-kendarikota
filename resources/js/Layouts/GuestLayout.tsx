import { PropsWithChildren } from "react";
import Navbar from "@/Components/Navbar";
import Topnav from "@/Components/TopNav";
import Footer from "@/Components/Footer";
import AnalyticsWidget from "@/Components/AnalyticsWidget";

export default function Guest({ children }: PropsWithChildren) {
  return (
    <div className="font-mulish">
      <AnalyticsWidget />
      <Topnav />
      <Navbar />
      {children}
      <Footer />
    </div>
  );
}
