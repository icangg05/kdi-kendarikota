import { Card } from "@/Components/card";
import { getFileName } from "@/lib/utils";
import parse from "html-react-parser";
import { Paperclip } from "lucide-react";

export default function CardDinamis({ title, content, lampiran }: any) {
  return (
    <Card className="rounded-2xl shadow-md p-6">
      <h2 className="text-lg font-semibold mb-2">{title}</h2>

      <div className="prose prose-sm prose-zinc mb-5">{parse(content)}</div>

      {lampiran && (
        <a
          href={`/storage/${lampiran}`}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-flex items-center gap-2 px-3 py-1.5 bg-[#1A3C61] text-white text-[13px] rounded-lg shadow hover:bg-black transition"
        >
          <Paperclip size={16} /> {getFileName(lampiran)}
        </a>
      )}
    </Card>
  );
}
