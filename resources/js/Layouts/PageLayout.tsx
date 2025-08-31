import { PropsWithChildren, useEffect, useState } from "react";
import HeroPage from "@/Components/HeroPage";
import SubDomain from "@/Components/SubDomain";
import {
  menuArsip,
  menuEvent,
  menuPeraturanDaerah,
  menuPPID,
  menuProfil,
  menuStatistik,
} from "@/lib/constant";

type PageLayoutProps = {
  title: string;
};

export default function PageLayout({
  title,
  children,
}: PropsWithChildren<PageLayoutProps>) {
  const [description, setDescription] = useState<any>(
    "Pemerintah Daerah Kota Kendari"
  );
  const [breadcrumb, setBreadcrumb] = useState<any>([]);

  useEffect(() => {
    const pathname = location.pathname;

    if (pathname.includes("/kendari-kita")) {
      setBreadcrumb([menuProfil.label, title]);
      setDescription(
        menuProfil.menu.find((item) => item.href == pathname)?.description
      );
    } else if (pathname.includes("/direktori")) {
      setBreadcrumb(["Direktori", title]);
    } else if (pathname.includes("/event")) {
      setBreadcrumb([menuEvent.label, title]);
      setDescription(
        menuEvent.menu.find((item) => item.href == pathname)?.description
      );
    } else if (pathname.includes("/arsip")) {
      setBreadcrumb([title]);
      setDescription(menuArsip.description);
    } else if (pathname.includes("/peraturan-daerah")) {
      setDescription(menuPeraturanDaerah.description);
      setBreadcrumb([title]);
    } else if (pathname.includes("/statistik")) {
      setDescription(menuStatistik.description);
      setBreadcrumb([title]);
    } else if (pathname.includes("/ppid")) {
      setDescription(menuPPID.description);
      setBreadcrumb([title]);
    } else {
      setBreadcrumb([title]);
    }
  }, []);

  return (
    <>
      <HeroPage
        title={title}
        description={description ?? title}
        breadcrumb={breadcrumb}
      />
      <div
        className="relative pb-8 bg-bottom bg-cover"
        style={{ backgroundImage: `url("/img/tesktur.jpg")` }}
      >
        <div className="absolute inset-0 bg-gradient-to-b from-white/100 via-white/0 to-white/100"></div>
        <div className="px-2 lg:px-0 relative z-20 -translate-y-20 lg:-translate-y-12">
          {children}
        </div>
      </div>

      {location.pathname != "/all-sub-domain" && (
        <div className="container">
          <SubDomain />
        </div>
      )}
    </>
  );
}
