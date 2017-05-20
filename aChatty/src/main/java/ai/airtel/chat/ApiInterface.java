package ai.airtel.chat;

import java.util.Map;

import retrofit2.Call;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.POST;

public interface ApiInterface {

    @FormUrlEncoded
    @POST("createUser.php")
    Call<General_Query> createUser(@FieldMap Map<String, String> names);


}
