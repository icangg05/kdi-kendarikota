const Walikota = ({ banner }: any) => {
  return (
    <div className="overflow-hidden w-full dark:bg-black bg-white dark:bg-grid-white/[0.2] bg-grid-black/[0.08] relative flex items-center justify-center">
      {/* Radial gradient for the container to give a faded look */}
      <div className="absolute pointer-events-none inset-0 flex items-center justify-center dark:bg-black bg-white [mask-image:radial-gradient(ellipse_at_center,transparent_20%,black)]"></div>
      <div className="container pb-14 pt-20 lg:pt-28">
        <img
          src={`/storage/${banner.image}`}
          alt={banner.image}
          className="w-full mx-auto lg:w-[70%] border rounded"
          loading="lazy"
        />
      </div>
    </div>
  );
};

export default Walikota;
