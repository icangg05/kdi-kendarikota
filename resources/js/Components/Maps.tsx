const Maps = ({
  name,
  latitude,
  longitude,
}: {
  name: string;
  latitude: number;
  longitude: number;
}) => {
  const mapSrc = `https://maps.google.com/maps?width=100%25&height=600&hl=en&q=${latitude},${longitude}(${encodeURIComponent(
    name
  )})&t=&z=16&ie=UTF8&iwloc=B&output=embed`;

  return (
    <iframe
      className="w-full aspect-[4/3] border rounded-lg shadow"
      frameBorder="0"
      scrolling="no"
      src={mapSrc}
      allowFullScreen
    ></iframe>
  );
};

export default Maps;
