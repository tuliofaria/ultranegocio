package com.jmsoft.ultranegocio;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.text.SimpleDateFormat;
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

import android.annotation.SuppressLint;
import android.content.Intent;
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

public class SignInActivity extends SherlockActivity {
	
	private EditText etName;
	private EditText etEmail;
	private EditText etPassword;
	private EditText etConfirmPassword;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.sign_in);
		
		etName = (EditText) findViewById(R.id.etName);
		etEmail = (EditText) findViewById(R.id.etEmail);
		etPassword = (EditText) findViewById(R.id.etPassword);
		etConfirmPassword = (EditText) findViewById(R.id.etConfirmPassword);
		
		etName.requestFocus();
		
		Button btnSignIn = (Button) findViewById(R.id.btnConfirm);
		btnSignIn.setOnClickListener(new OnClickListener() {
			
			@SuppressLint("SimpleDateFormat")
			@Override
			public void onClick(View arg0) {
				if(checkWidgets()){
					//Parametros para o Async Task
					SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
					String created = sdf.format(new Date());
					
					Map<String, String> params = new HashMap<String, String>();
//					params.put("id", "0");
					params.put("nome", etName.getText().toString());
					params.put("email", etEmail.getText().toString());
					params.put("senha", etPassword.getText().toString());
					params.put("created", created);
					params.put("modified", created);
					params.put("deleted", "0");
					params.put("email_confirmado", "1");
									
					SignInTask task = new SignInTask();
					task.execute(params);
				}
			}
		});
	}
	
	public boolean checkWidgets(){
		if(etName.getText().toString().equals("") || etEmail.getText().toString().equals("")
				|| etPassword.getText().toString().equals("") || etConfirmPassword.getText().toString().equals("")){
			Toast.makeText(this, "Campos obrigatórios não preenchidos", Toast.LENGTH_LONG).show();
			return false;
		}
		
		if(etPassword.getText().toString().equals(etConfirmPassword.getText().toString()) == false){
			Toast.makeText(this, "A confirmação da senha não bate", Toast.LENGTH_LONG).show();
			return false;
		}
		
		return true;
	}

	private class SignInTask extends AsyncTask<Object, Object, Object> {

		@Override
		protected Object doInBackground(Object... params) {		
			HttpParams httpParameters = new BasicHttpParams();
	        int timeoutConnection = 30000;
	        HttpConnectionParams.setConnectionTimeout(httpParameters, timeoutConnection);
	        
	        int timeoutSocket = 30000;
	        HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);
			
			HttpClient httpclient = new DefaultHttpClient();
		    HttpPost httppost = new HttpPost(IPs.signIn);
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
							Toast.makeText(getApplicationContext(), "Usuário registrado com sucesso!", Toast.LENGTH_SHORT).show();
						}
					});
					Intent i = new Intent(getApplicationContext(), AnouncementActivity.class);
					i.putExtra("id", Integer.parseInt(result));
					i.putExtra("email", etEmail.getText().toString());
					i.putExtra("name", etName.getText().toString());
					
					startActivity(i);
					
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
