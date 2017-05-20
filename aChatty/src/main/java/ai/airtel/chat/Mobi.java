package ai.airtel.chat;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import java.util.HashMap;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class Mobi extends AppCompatActivity {

    public static final String TAG = Mobi.class.getName();
    Button addB;
    @Override
    protected void onCreate( Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.dialog_mobi);
        addB = (Button) findViewById(R.id.addButton);
        addB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(final View v) {
                String num = ((EditText)findViewById(R.id.mobiNum)).getText().toString();
                String nameM = ((EditText)findViewById(R.id.Namea)).getText().toString();
                String address = ((EditText)findViewById(R.id.addresss)).getText().toString();
                TextView textView = (TextView)((Spinner) findViewById(R.id.typeSpinner)).getSelectedView();
                String type = textView.getText().toString();

                ApiInterface apiService =
                        ApiClient.getClient().create(ApiInterface.class);
                Map<String, String> names = new HashMap<String, String>();
                names.put("mobileNumber", num);
                names.put("type", type);
                names.put("address", address);
                names.put("name", nameM);
                Call<General_Query> call = apiService.createUser(names);
                call.enqueue(new Callback<General_Query>() {
                    @Override
                    public void onResponse(Call<General_Query> call, Response<General_Query> response) {
                        if (response.body() != null) {

                            int success = response.body().getSuccess();
                            String message = response.body().getMessage();
                            Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT).show();
                            onBackPressed();
                            finish();
                        }


                    }

                    @Override
                    public void onFailure(Call<General_Query> call, Throwable t) {
                        // Log error here since request failed
                        Log.e(TAG, t.toString());
                    }
                });
            }
        });
    }


}
