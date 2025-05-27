import { useTwibbonCanvas } from "@/hooks/useTwibbonCanvas";
import { cn } from "@/lib/utils";
import { useEffect, useState } from "react";
import Canvas from "@/Components/twibbon/Canvas";
import { Button } from "../button";

export default function Form({ title, frameTwibbon }: any) {
  function downloadURI(uri: string, name: string) {
    const link = document.createElement("a");
    link.download = name;
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  const canvasHook = useTwibbonCanvas();

  const [fileName, setFileName] = useState<string>();
  const [scale, setScale] = useState<number>(1);

  useEffect(() => {
    canvasHook.addBackground(frameTwibbon!);
  }, [canvasHook]);

  useEffect(() => {
    canvasHook.setScaled(scale);
  }, [scale]);

  return (
    <div className="flex flex-col gap-4">
      <div className="flex justify-center items-center space-y-4 flex-col">
        <Canvas
          width={canvasHook.recommendedSize.width}
          height={canvasHook.recommendedSize.height}
          canvasid="twibbon"
          ref={canvasHook.canvasRef}
        />
        <div
          className={cn(
            "w-full flex flex-col items-center gap-1 mt-10 justify-center",
            !fileName ? "hidden" : null
          )}
        >
          <label htmlFor="zoom" className="font-semibold text-xs lg:text-sm">
            Zoom {(Math.round((scale + Number.EPSILON) * 100) / 100).toString()}
            x
          </label>
          <div className="flex items-center gap-3">
            <Button
              variant={"outline"}
              size={"sm"}
              onClick={() => setScale((prev) => prev - 0.05)}
            >
              -
            </Button>
            <input
              id="zoom"
              type="range"
              min="0.2"
              max="3"
              step="0.05"
              value={scale}
              onChange={(e) => setScale(parseFloat(e.currentTarget.value))}
              className="
                appearance-none w-[10rem] md:w-[15rem] h-1
                bg-gray-300 rounded-lg cursor-pointer
                transition-all duration-300
                focus:outline-none focus:ring-0
                [&::-webkit-slider-thumb]:appearance-none
                [&::-webkit-slider-thumb]:w-2.5
                [&::-webkit-slider-thumb]:h-2.5
                [&::-webkit-slider-thumb]:bg-[#1A5590]
                [&::-webkit-slider-thumb]:rounded-full
                [&::-webkit-slider-thumb]:shadow-md
                [&::-webkit-slider-thumb]:cursor-pointer
                [&::-webkit-slider-thumb]:transition-all
                [&::-webkit-slider-thumb]:duration-300
                "
            />
            <Button
              variant={"outline"}
              size={"sm"}
              onClick={() => setScale((prev) => prev + 0.05)}
            >
              +
            </Button>
          </div>
        </div>
      </div>

      <div className="flex flex-row items-center space-x-1">
        <div className="w-full">
          <input
            className="hidden"
            type="file"
            id="foto"
            accept="image/png, image/jpeg, image/jpg"
            onChange={async (ev) => {
              setFileName(ev.currentTarget.files?.[0]?.name);

              if (ev.currentTarget.files?.length) {
                canvasHook.addFrame(
                  URL.createObjectURL(ev.currentTarget.files[0])
                );
              }
            }}
          />
          <label
            htmlFor="foto"
            className="w-full bg-[#1A5590] hover:bg-opacity-90 transition ease-out text-[10px] lg:text-xs font-sen text-white font-medium uppercase tracking-wide text-center rounded h-8 flex items-center justify-center"
          >
            Pilih Foto
          </label>
        </div>
        <Button
          onClick={() => {
            if (!fileName) return;
            const data = canvasHook.toDataUrl();

            if (data) {
              downloadURI(data, `${title}.jpg`);
            }
          }}
          className={`w-full bg-[#1A5590] hover:bg-opacity-90 transition ease-out text-[10px] lg:text-xs font-sen text-white font-medium uppercase tracking-wide rounded h-8 flex items-center justify-center ${
            !fileName && "!pointer-events-none !opacity-60"
          }`}
        >
          Download
        </Button>
      </div>
    </div>
  );
}
