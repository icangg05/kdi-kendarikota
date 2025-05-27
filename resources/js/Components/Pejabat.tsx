import { Navigation } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";

import { Card } from "@/Components/card";
import { BackgroundGradientAnimation } from "./ui/aceternity/background-gradient-animation";

// Import Swiper styles
import "swiper/css";
import CardTwibbonGenerate from "./CardTwibbonGenerate";
import { useEffect, useState } from "react";
import axios from "axios";
import { CircleArrowLeft, CircleArrowRight } from "lucide-react";

interface Video {
  id: string;
  snippet: {
    title: string;
    description: string;
    thumbnails: {
      medium: {
        url: string;
      };
    };
  };
  contentDetails: {
    duration: string;
  };
  statistics: {
    viewCount: string;
    likeCount: string;
  };
}

// Definisikan tipe untuk props
interface VideoDetailProps {
  videoId: string;
}

const VideoDetail: React.FC<VideoDetailProps> = ({ videoId }) => {
  const [video, setVideo] = useState<Video | null>(null);
  const API_KEY = "AIzaSyBgSr0MQQDhm_yPgzAQ1HYOA7-RO2CikcU";

  useEffect(() => {
    const fetchVideoDetails = async () => {
      try {
        const response = await axios.get(
          `https://www.googleapis.com/youtube/v3/videos?key=${API_KEY}&id=${videoId}&part=snippet,contentDetails,statistics`
        );
        setVideo(response.data.items[0]); // Ambil item pertama dari hasil
      } catch (error) {
        console.error("Error fetching video details:", error);
      }
    };

    fetchVideoDetails();
  }, [videoId, API_KEY]);

  if (!video) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      <iframe
        className="absolute top-0 left-0 w-full h-full rounded-lg"
        src={`https://www.youtube.com/embed/${videoId}`}
        title="YouTube video player"
        frameBorder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowFullScreen
      ></iframe>
    </div>
  );
};

const Pejabat = ({ twibbon, youtube }: any) => {
  return (
    <section className="pb-6 lg:pb-20 mt-4 lg:mt-0">
      <div className="container grid grid-cols-10 gap-8">
        <div className="col-span-10 lg:col-span-7">
          <BackgroundGradientAnimation className="flex items-center justify-center w-full h-full">
            <div className="text-white w-full px-3.5 lg:px-10">
              <div className="mb-1 flex items-start justify-between">
                <h1 className="font-sen text-xl lg:text-3xl font-bold">
                  Video
                </h1>
                <div className="flex gap-1">
                  <button
                    aria-label="prev button"
                    className="swiper-button-prev-video text-zinc-100/70"
                  >
                    <CircleArrowLeft className="size-6 lg:size-7" />
                  </button>
                  <button
                    aria-label="next button"
                    className="swiper-button-next-video text-zinc-100/70"
                  >
                    <CircleArrowRight className="size-6 lg:size-7" />
                  </button>
                </div>
              </div>
              <p className="text-xs lg:text-sm italic">
                Video program dan kegiatan Pemerintah Kota Kendari
              </p>
              {/* Frame Video */}
              <Card className="mt-7 p-1.5 lg:p-4 w-full bg-white/20 border-none">
                <Swiper
                  modules={[Navigation]}
                  slidesPerView={1}
                  loop
                  navigation={{
                    nextEl: ".swiper-button-next-video",
                    prevEl: ".swiper-button-prev-video",
                  }}
                >
                  {youtube.map((item: any, i: any) => (
                    <SwiperSlide key={i}>
                      <div
                        className="relative w-full"
                        style={{ paddingTop: "56.25%" }}
                      >
                        <VideoDetail videoId={item.link} />
                      </div>
                    </SwiperSlide>
                  ))}
                </Swiper>
              </Card>
            </div>
          </BackgroundGradientAnimation>
        </div>

        <div className="col-span-10 lg:col-span-3">
          <div className="mb-7">
            <h1 className="font-sen text-xl font-bold">Twibbon</h1>
            <p className="mb-5 text-xs lg:text-sm italic">
              Unggah foto untuk membuat twibbon kamu
            </p>
            <CardTwibbonGenerate twibbon={twibbon} />
          </div>
        </div>
      </div>
    </section>
  );
};

export default Pejabat;
