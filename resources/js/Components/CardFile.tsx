import { Button } from "@/Components/button";
import { Card, CardContent, CardHeader } from "@/Components/card";
import { Download, FileText } from "lucide-react";

export default function DownloadCard({ fileName, sumber, downloadUrl }: any) {
  return (
    <Card className="px-1 pt-2 w-full h-full shadow-lg rounded-2xl">
      <CardHeader className="flex flex-col items-center">
        <FileText size={60} className="text-gray-500" />
      </CardHeader>
      <CardContent>
        <div className="text-sm font-semibold leading-snug">{fileName}</div>
        <div className="text-xs mt-1.5 mb-5">
          <span className="text-black/70">
            {location.pathname.includes("/peraturan-daerah")
              ? "Tentang : "
              : location.pathname.includes("/statistik")
              ? "Keterangan : "
              : "Sumber : "}
          </span>
          {sumber}
        </div>
        <Button
          className="w-full text-xs flex items-center gap-2 bg-[#173454] hover:bg-opacity-90"
          onClick={() => window.open(downloadUrl, "_blank")}
        >
          <Download size={16} /> Download
        </Button>
      </CardContent>
    </Card>
  );
}
