package com.jmsoft.ultranegocio;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.StatusLine;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.actionbarsherlock.app.SherlockActivity;
import com.jmsoft.ultranagocio.R;
import com.jmsoft.ultranegocio.adapter.AnnouncementAdapter;
import com.jmsoft.ultranegocio.entity.Announcement;
import com.jmsoft.ultranegocio.entity.IPs;

public class AnouncementActivity extends SherlockActivity {

	private ListView listView;
	private List<Announcement> announces;
	private int id;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.anouncement);

		listView = (ListView) findViewById(R.id.lstAnnouncements);

		TextView txtWelcome = (TextView) findViewById(R.id.txtWelcome);
		Bundle bundle = getIntent().getExtras();
		txtWelcome.setText(txtWelcome.getText() + ": "
				+ bundle.getString("name"));

		id = bundle.getInt("id");

		Button btnRegister = (Button) findViewById(R.id.btnRegister);
		btnRegister.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				Intent i = new Intent(getApplicationContext(),
						AddAnnouncementActivity.class);
				i.putExtra("id", id);
				startActivityForResult(i, 1);
			}
		});

		AnnouncementsTask task = new AnnouncementsTask();
		task.execute();
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (resultCode == Activity.RESULT_OK) {
			AnnouncementsTask task = new AnnouncementsTask();
			task.execute();
		}
	}
	
	private class AnnouncementsTask extends AsyncTask<Object, Object, Object> {
		@Override
		protected Object doInBackground(Object... params) {
			HttpParams httpParameters = new BasicHttpParams();
			int timeoutConnection = 30000;
			HttpConnectionParams.setConnectionTimeout(httpParameters,
					timeoutConnection);

			int timeoutSocket = 30000;
			HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);

			HttpClient httpclient = new DefaultHttpClient();
			HttpPost httppost = new HttpPost(IPs.announcements);
			StringBuilder builder = new StringBuilder();

			String line;
			String dados;

			try {
				httppost.setEntity(new StringEntity(""));
				httppost.setHeader("Accept", "application/json");
				httppost.setHeader("Content-type", "application/json");

				// Executa HTTP Post Request
				HttpResponse response = httpclient.execute(httppost);
				StatusLine statusLine = response.getStatusLine();

				int statusCode = statusLine.getStatusCode();

				if (statusCode == 200) {

					HttpEntity entity = response.getEntity();
					InputStream content = entity.getContent();
					BufferedReader reader = new BufferedReader(
							new InputStreamReader(content));

					while ((line = reader.readLine()) != null) {
						builder.append(line);
					}
				}

				dados = builder.toString();

				JSONObject jsonResponse = new JSONObject(dados);
				JSONArray result = jsonResponse.getJSONArray("anuncios");

				announces = new ArrayList<Announcement>();

				for (int i = 0; i < result.length(); i++) {
					String jsonObject = result.get(i).toString();
					JSONObject json = new JSONObject(jsonObject)
							.getJSONObject("Anuncio");

					Announcement announcement = new Announcement();
					announcement.setId(Integer.parseInt(json.getString("id")));
					announcement.setDescription(json.getString("description"));
					announcement.setPrice(json.getString("descricao"));
					announcement.setWeight(json.getString("peso"));
					announcement.setCep(json.getString("cep_origem"));
					announcement
							.setBlobDescription(json.getString("descricao"));
					announcement.setKeywords(json.getString("keywords"));

					announces.add(announcement);
				}

				runOnUiThread(new Runnable() {

					@Override
					public void run() {
						AnnouncementAdapter adapter = new AnnouncementAdapter(
								getApplicationContext(), announces);

						listView.setAdapter(adapter);

						listView.setOnItemClickListener(new OnItemClickListener() {

							@Override
							public void onItemClick(AdapterView<?> arg0,
									View v, int position, long arg3) {

								Announcement item = (Announcement) listView
										.getItemAtPosition(position);
								Intent iNewPerson = new Intent(
										AnouncementActivity.this,
										AddAnnouncementActivity.class);
								iNewPerson.putExtra("id", item.getId());
							}

						});
					}
				});
			} catch (JSONException e) {
				e.printStackTrace();
				runOnUiThread(new Runnable() {

					@Override
					public void run() {
						Toast.makeText(getApplicationContext(),
								"Usuário inválido", Toast.LENGTH_SHORT).show();
					}
				});

			} catch (IOException e) {
				e.printStackTrace();
				runOnUiThread(new Runnable() {

					@Override
					public void run() {
						Toast.makeText(getApplicationContext(),
								"Exceção na conexão", Toast.LENGTH_SHORT)
								.show();
					}
				});

			}
			return null;
		}
	}
}
