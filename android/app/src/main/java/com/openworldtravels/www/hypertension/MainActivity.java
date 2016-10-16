package com.openworldtravels.www.hypertension;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;

import io.netpie.microgear.Microgear;

public class MainActivity extends AppCompatActivity {
    private final Microgear microgear = new Microgear(this);
    private String appid = "Hypertension"; //APP_ID
    private String key = "hCOs4P1PsSaANgY"; //KEY
    private String secret = "Ztt2nX3O2CwobnKszSv1B5vqg"; //SECRET

    Handler handler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            Bundle bundle = msg.getData();
            String string = bundle.getString("myKey");
            Log.i("Message",string);
           // TextView myTextView = (TextView)findViewById(R.id.editText);
           // myTextView.append(string+"\n");
        }
    };


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        NetpieIOHelper callback = new NetpieIOHelper(handler);
        microgear.connect(appid, key, secret);
        microgear.setCallback(callback);
        microgear.subscribe("patient1");
        microgear.setalias("android1");

        (new Thread(new Runnable()
        {
            int count = 1;
            @Override
            public void run()
            {
                while (!Thread.interrupted())
                    try
                    {
                        runOnUiThread(new Runnable() // start actions in UI thread
                        {
                            @Override
                            public void run(){
                                microgear.publish("patient1", String.valueOf(count++)+".  Test message", 3, false);
                                microgear.publish("patient2", String.valueOf(count++)+".  Test message", 3, false);
                            }
                        });
                        Thread.sleep(2000);
                    }
                    catch (InterruptedException e)
                    {
                        // ooops
                    }
            }
        })).start();

    }

    protected void onDestroy() {
        super.onDestroy();
        microgear.disconnect();
    }

    protected void onResume() {
        super.onResume();
        microgear.bindServiceResume();
    }

    protected void onClickLogin(View view){
        Intent intent = new Intent(this, MainMenuActivity.class);
        startActivity(intent);
    }


}