package com.jmsoft.ultranegocio.adapter;

import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.jmsoft.ultranagocio.R;
import com.jmsoft.ultranegocio.entity.Announcement;

public class AnnouncementAdapter extends BaseAdapter {

	private List<Announcement> lstAnnouncement;
	private LayoutInflater mInflater;
	private ViewHolder holder;

	static class ViewHolder {
		private TextView tvDescription;
		private TextView tvPrice;
		private TextView tvWeight;
		private TextView tvOrigin;
		private TextView tvKeywords;
		private ImageView picture;
	}

	public AnnouncementAdapter(Context context, List<Announcement> announcements) {
		mInflater = LayoutInflater.from(context);
		this.lstAnnouncement = announcements;
	}

	@Override
	public int getCount() {
		return lstAnnouncement.size();
	}

	@Override
	public Object getItem(int index) {
		return lstAnnouncement.get(index);
	}

	@Override
	public long getItemId(int index) {
		return index;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup arg2) {
		if (convertView == null) {
			convertView = mInflater.inflate(R.layout.adapter, null);
			holder = new ViewHolder();

			holder.tvDescription = (TextView) convertView
					.findViewById(R.id.txtDescription);
			holder.tvPrice = (TextView) convertView
					.findViewById(R.id.txtPrice);
			holder.tvWeight = (TextView) convertView
					.findViewById(R.id.txtWeight);
			holder.tvOrigin = (TextView) convertView
					.findViewById(R.id.txtOrigin);
			holder.tvKeywords = (TextView) convertView
					.findViewById(R.id.txtKeywords);
			holder.picture = (ImageView) convertView.findViewById(R.id.ivAnnounce);

			convertView.setTag(holder);

		} else {
			holder = (ViewHolder) convertView.getTag();
		}

		if(lstAnnouncement != null && position < lstAnnouncement.size()) {
			Announcement announce = lstAnnouncement.get(position);
			holder.tvDescription.setText("Descrição: " + announce.getBlobDescription());
			holder.tvPrice.setText("Preço: " + announce.getPrice());
			holder.tvWeight.setText("Peso: " + announce.getWeight());
			holder.tvOrigin.setText("Origem: " + announce.getCep());
			holder.tvKeywords.setText("Keywords: " + announce.getKeywords());
		}
		return convertView;
	}

}
