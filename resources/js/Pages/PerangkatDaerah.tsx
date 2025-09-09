import GuestLayout from "@/Layouts/GuestLayout";
import { Card } from "@/Components/card";
import PageLayout from "@/Layouts/PageLayout";
import { Download, LayoutPanelTop } from "lucide-react";
import { Dialog, DialogContent, DialogTrigger } from "@/Components/ui/dialog";
import { Button } from "@/Components/button";

export default function PerangkatDaerah({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  const handleDownload = (fileUrl: string, fileName?: string) => {
    const link = document.createElement("a");
    link.href = `${location.origin}/storage/${fileUrl}`;
    link.download = fileName || fileUrl.split("/").pop() || "file";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  };

  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-6xl mx-auto grid grid-cols-2 gap-5 lg:gap-7">
          {data.map((item: any, i: any) => (
            <div key={i} className="col-span-2 lg:col-span-1">
              <Card className="bg-white/95 backdrop-blur-md shadow-[0px_4px_16px_rgba(17,17,26,0.1),_0px_8px_24px_rgba(17,17,26,0.1),_0px_16px_56px_rgba(17,17,26,0.1)] rounded-2xl px-6 py-5 w-full border border-white/30">
                <p className="font-extrabold text-base text-[#173454] font-sen uppercase">
                  {item.nama}
                </p>
                <div className="h-[95px] mt-3 overflow-y-scroll custom-scrollbar">
                  <ul className="flex flex-col space-y-1.5 lg:space-y-1 text-xs lg:text-sm">
                    {item.opd.map((list: any, j: any) => (
                      <li
                        key={j}
                        className="flex gap-3 lg:gap-5 items-center justify-between pr-4"
                      >
                        <div className="flex items-center space-x-2">
                          <span className="size-2 bg-blue-800"></span>
                          <span>{list.nama}</span>
                        </div>
                        <div>
                          <Dialog>
                            <DialogTrigger
                              asChild
                              disabled={
                                list.files == null || list.files.length == 0
                              }
                            >
                              <button
                                className={`flex text-nowrap items-center space-x-1.5 font-extrabold bg-[#1A5590] text-white text-[10px] lg:text-[8px] px-3 lg:px-2 rounded py-0.5 hover:bg-opacity-90 transition ease-out ${
                                  list.files == null || list.files.length == 0
                                    ? "cursor-not-allowed opacity-60"
                                    : "cursor-pointer"
                                }`}
                              >
                                <LayoutPanelTop className="w-[12px] lg:w-[10px]" />
                                <span className="hidden lg:inline uppercase">
                                  Struktur OPD
                                </span>
                              </button>
                            </DialogTrigger>
                            <DialogContent className="px-3 lg:px-6 py-6 h-[80vh] lg:h-[90vh]">
                              <div className="pb-7">
                                <div className="pr-8 lg:pr-6 mb-2.5 flex justify-between items-center space-x-5">
                                  <div className="font-bold font-sen leading-tight">
                                    Struktur OPD -{" "}
                                    <span className="text-nthmain">
                                      {list.nama}
                                    </span>
                                  </div>
                                  <Button
                                    onClick={() => {
                                      if (
                                        list.files != null ||
                                        list.files.length != 0
                                      ) {
                                        handleDownload(
                                          list.files[0],
                                          `Struktur OPD - ${list.nama} Kota Kendari`
                                        );
                                      }
                                    }}
                                    className="flex items-center"
                                    variant={"outline"}
                                    size={"sm"}
                                  >
                                    <Download />
                                    <span className="hidden lg:inline">
                                      Download
                                    </span>
                                  </Button>
                                </div>

                                {list.files != null && (
                                  <div className="h-full border-2 overflow-scroll custom-scrollbar">
                                    <iframe
                                      src={`/storage/${list.files}`}
                                      className="w-full h-full border rounded-md"
                                    />
                                  </div>
                                )}
                              </div>
                            </DialogContent>
                          </Dialog>
                        </div>
                      </li>
                    ))}
                  </ul>
                </div>
              </Card>
            </div>
          ))}
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
