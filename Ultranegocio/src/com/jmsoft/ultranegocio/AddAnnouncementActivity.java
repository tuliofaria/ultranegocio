package com.jmsoft.ultranegocio;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.HashMap;
import java.util.Map;

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
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.actionbarsherlock.app.SherlockActivity;
import com.google.gson.GsonBuilder;
import com.jmsoft.ultranagocio.R;
import com.jmsoft.ultranegocio.entity.IPs;

public class AddAnnouncementActivity extends SherlockActivity {
	
	private EditText etTitle;
	private EditText etBlobDescription;
	private EditText etPrice;
	private EditText etWeight;
	private EditText etCEP;
	private EditText etKeywords;
	private EditText etDescription;
	private int id;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.new_announcement);
		
		id = getIntent().getIntExtra("id", 0);
		
		etTitle = (EditText) findViewById(R.id.etTitle);
		etBlobDescription = (EditText) findViewById(R.id.etBlogDescription);
		etPrice = (EditText) findViewById(R.id.etPrice);
		etWeight = (EditText) findViewById(R.id.etWeight);
		etCEP = (EditText) findViewById(R.id.etCep);
		etKeywords = (EditText) findViewById(R.id.etKeywords);
		etDescription = (EditText) findViewById(R.id.etDescription);
		etTitle.requestFocus();

		Button btnConfirm = (Button) findViewById(R.id.btnConfirm);
		btnConfirm.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				if(checkWidgets()){
					Map<String, String> params = new HashMap<String, String>();
					params.put("titulo", etTitle.getText().toString());
					params.put("descricao", etBlobDescription.getText().toString());
					params.put("preco", etPrice.getText().toString());
					params.put("peso", etWeight.getText().toString());
					params.put("cep_origem", etCEP.getText().toString());
					params.put("keywords", etKeywords.getText().toString());
					params.put("description", etDescription.getText().toString());
					params.put("usuario_id", String.valueOf(id));
					
					AnnouncementsTask task = new AnnouncementsTask();
					task.execute(params);
				}
			}
		});
	}
	
	public boolean checkWidgets(){
		if(etTitle.getText().toString().equals("") || etBlobDescription.getText().toString().equals("")
				|| etPrice.getText().toString().equals("") || etWeight.getText().toString().equals("")
				|| etWeight.getText().toString().equals("") || etCEP.getText().toString().equals("")
				|| etKeywords.getText().toString().equals("") || etDescription.getText().toString().equals("")){
			Toast.makeText(this, "Campos obrigatórios não preenchidos", Toast.LENGTH_LONG).show();
			return false;
		}		
		return true;
	}

	private class AnnouncementsTask extends AsyncTask<Object, Object, Object> {
		@Override
		protected Object doInBackground(Object... params) {
			HttpParams httpParameters = new BasicHttpParams();
	        int timeoutConnection = 30000;
	        HttpConnectionParams.setConnectionTimeout(httpParameters, timeoutConnection);
	        
	        int timeoutSocket = 30000;
	        HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);
			
			HttpClient httpclient = new DefaultHttpClient();
		    HttpPost httppost = new HttpPost(IPs.addAnnouncement);
		    StringBuilder builder = new StringBuilder();	    
		    
		    String result;
		    String line;
		    String data;
		    
		    try{
		    	@SuppressWarnings("unchecked")
				Map<String, String> parameters = (Map<String,String>) params[0];
		    	String json = new GsonBuilder().create().toJson(parameters, Map.class);
		               
		    	httppost.setEntity(new StringEntity(json));
		    	httppost.setHeader("Accept", "application/json");
		    	httppost.setHeader("Content-type", "application/json");
		        
		        // Executa HTTP Post Request
			    HttpResponse response = httpclient.execute(httppost);
			    StatusLine statusLine = response.getStatusLine();
				    
				int statusCode = statusLine.getStatusCode();
				    
				if (statusCode == 200) {
				    	
					HttpEntity entity = response.getEntity();
					InputStream content = entity.getContent();
					BufferedReader reader = new BufferedReader(new InputStreamReader(content));
				    	
				    while ((line = reader.readLine()) != null) {
				    	builder.append(line);
				    }
				}
				    
				data = builder.toString();
				    	
				JSONObject jsonResponse = new JSONObject(data);			
				result = jsonResponse.getString("id");			
				    
				if (Integer.parseInt(result) > 0){					
					runOnUiThread(new Runnable() {
						
						@Override
						public void run() {
							Toast.makeText(getApplicationContext(), "Anúncio registrado com sucesso!", Toast.LENGTH_SHORT).show();
						}
					});
					setResult(Activity.RESULT_OK);
					finish();
					
				} else{
				    runOnUiThread(new Runnable() {
						
						@Override
						public void run() {
							Toast.makeText(getApplicationContext(), "Houve um erro!", Toast.LENGTH_SHORT).show();
						}
					});
				}
		    } catch (JSONException e) {
		    	e.printStackTrace();
		    	runOnUiThread(new Runnable() {
					
					@Override
					public void run() {
						Toast.makeText(getApplicationContext(), "Exceção no JSON", Toast.LENGTH_SHORT).show();
					}
				});
		    	
			} catch (IOException e) {
				e.printStackTrace();
				runOnUiThread(new Runnable() {
					
					@Override
					public void run() {
						Toast.makeText(getApplicationContext(), "Exceção na conexão", Toast.LENGTH_SHORT).show();
					}
				});
				
			}
			return null;
		}
	}
}
