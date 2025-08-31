import { useState } from 'react';
import { IconChartBar } from '@tabler/icons-react';
import { usePage } from '@inertiajs/react';

export default function AnalyticsWidget() {
  const [collapsed, setCollapsed] = useState(false);
  const { analytics }: any = usePage().props;

  return (
    <div
      className={`${collapsed ? '-translate-x-0' : 'translate-x-[74%]'
        } pointer-events-none fixed right-3 top-1/2 transform -translate-y-1/2 z-[999] flex items-center transition ease-in-out duration-500`}
    >
      {/* Tombol Vertikal + Icon */}
      <div
        onClick={() => setCollapsed(!collapsed)}
        className="pointer-events-auto font-sen cursor-pointer translate-x-11 -rotate-90 tracking-[2px] bg-[#1A3C61] text-white px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1"
      >
        <IconChartBar className='mr-1' size={14} />
        Statistik
      </div>

      {/* Panel Statistik */}
      <div className="bg-white shadow-lg rounded-2xl w-80 transition-all duration-300 ease-in-out overflow-hidden">
        <div className="flex items-center justify-between px-4 py-3 bg-[#173454] text-white rounded-t-2xl">
          <h2 className="font-semibold font-sen text-base">Statistik Kunjungan</h2>
        </div>

        <div className="space-y-4 p-4 bg-blue-50">
          <div className="bg-white rounded-xl shadow p-4">
            <p className="text-sm text-gray-500">Total Visitor</p>
            <h3 className="text-xl font-bold">{analytics.totalVisitors.toLocaleString()}</h3>
          </div>

          <div className="bg-white rounded-xl shadow p-4">
            <p className="text-sm text-gray-500">Total View</p>
            <h3 className="text-xl font-bold">{analytics.totalViews.toLocaleString()}</h3>
          </div>

          <div className="bg-white rounded-xl shadow p-4">
            <p className="text-sm text-gray-500">Online Users</p>
            <h3 className="text-xl font-bold">{analytics.onlineUsers}</h3>
          </div>
        </div>
      </div>
    </div>
  );
}
