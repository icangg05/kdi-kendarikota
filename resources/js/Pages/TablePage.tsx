import GuestLayout from "@/Layouts/GuestLayout";
import { Card } from "@/Components/card";
import PageLayout from "@/Layouts/PageLayout";
import { DataTable } from "@/Components/DataTable";
import {
  columnsArsip,
  columnsPengumuman,
  columnsPerda,
  columnsStatistik,
} from "@/lib/constant";
import { useEffect, useState } from "react";

export default function TablePage({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  const [columns, setColumns] = useState<any>([]);
  const [keySearch, setKeySearch] = useState<string>("");

  useEffect(() => {
    const pathname = location.pathname;

    if (pathname.includes("/event/pengumuman")) {
      setColumns(columnsPengumuman);
      setKeySearch("judul");
    }
    if (pathname.includes("/arsip")) {
      setColumns(columnsArsip);
      setKeySearch("judul");
    }
    if (pathname.includes("/peraturan-daerah")) {
      setColumns(columnsPerda);
      setKeySearch("no_perda");
    }
    if (pathname.includes("/statistik")) {
      setColumns(columnsStatistik);
      setKeySearch("judul");
    }
  }, []);

  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-6xl mx-auto">
          <Card className="p-3 px-6 lg:p-8 lg:px-11">
            <DataTable data={data} columns={columns} keySearch={keySearch} />
          </Card>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
