package com.jmsoft.ultranegocio;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
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

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.actionbarsherlock.app.SherlockActivity;
import com.google.gson.GsonBuilder;
import com.jmsoft.ultranagocio.R;
import com.jmsoft.ultranegocio.entity.IPs;

public class MainActivity extends SherlockActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);

		// Check UI components values
		final EditText etEmail = (EditText) findViewById(R.id.etEmail);
		final EditText etPassword = (EditText) findViewById(R.id.etPassword);

		// Sign in button
		Button btnLogin = (Button) findViewById(R.id.btnLogin);
		btnLogin.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				if(etEmail.getText().toString().equals("")){
					Toast.makeText(getApplicationContext(), getResources().getString(R.string.enter_name), Toast.LENGTH_LONG).show();
					return;
				}
				
				if(etPassword.getText().toString().equals("")){
					Toast.makeText(getApplicationContext(), getResources().getString(R.string.enter_password), Toast.LENGTH_LONG).show();
					return;
				}
				
				Map<String, String> params = new HashMap<String, String>();
				params.put("user", etEmail.getText().toString());
				params.put("passwd", etPassword.getText().toString());
								
				LoginTask task = new LoginTask();
				task.execute(params);
			}
		});

		// Sign in button
		Button btnSignIn = (Button) findViewById(R.id.btnSignIn);
		btnSignIn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				startActivity(new Intent(getApplicationContext(), SignInActivity.class));
			}
		});
	}
	
	private class LoginTask extends AsyncTask<Object, Object, Object> {

		@Override
		protected Object doInBackground(Object... params) {		
			HttpParams httpParameters = new BasicHttpParams();
	        int timeoutConnection = 30000;
	        HttpConnectionParams.setConnectionTimeout(httpParameters, timeoutConnection);
	        
	        int timeoutSocket = 30000;
	        HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);
			
			HttpClient httpclient = new DefaultHttpClient();
		    HttpPost httppost = new HttpPost(IPs.login);
		    StringBuilder builder = new StringBuilder();	    
		    
		    String retorno;
		    String line;
		    final String mens;
		    String dados;
		    
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
				    
				dados = builder.toString();
				    	
				JSONObject jsonResponse = new JSONObject(dados);			
				retorno = jsonResponse.getString("msg");			
				    
				if (retorno.equals("Authorized")){					
					jsonResponse = new JSONObject(jsonResponse.getString("user"));
						
					int id = Integer.parseInt(jsonResponse.getString("id"));
					String name = jsonResponse.getString("nome");
					String email = jsonResponse.getString("email");
					
					Intent it = new Intent(getApplicationContext(), AnouncementActivity.class);
					Bundle user = new Bundle();
					
					user.putString("name", name);
					user.putString("email", "email");
					user.putInt("id", id);
					
					it.putExtras(user);
														
					startActivity(it);
				} else{
				    mens = jsonResponse.getString("Reason");
				    runOnUiThread(new Runnable() {
						
						@Override
						public void run() {
							Toast.makeText(getApplicationContext(), mens, Toast.LENGTH_SHORT).show();
						}
					});
				}
		    } catch (JSONException e) {
		    	e.printStackTrace();
		    	runOnUiThread(new Runnable() {
					
					@Override
					public void run() {
						Toast.makeText(getApplicationContext(), "Usuário ou senha inválido", Toast.LENGTH_SHORT).show();
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
