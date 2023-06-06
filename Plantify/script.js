$(document).ready(function() {
    var url_humidtiy = "https://api.thingspeak.com/channels/2090610/fields/1/last.json?api_key=MXCE7L7HZA5MAOJR";
    var url_temp = "https://api.thingspeak.com/channels/2090610/fields/2/last.json?api_key=MXCE7L7HZA5MAOJR";
    var url_LM = "https://api.thingspeak.com/channels/2090610/fields/3/last.json?api_key=MXCE7L7HZA5MAOJR";
    var url_Soil = "https://api.thingspeak.com/channels/2090610/fields/4/last.json?api_key=MXCE7L7HZA5MAOJR";
    var url_waterLevel = "https://api.thingspeak.com/channels/2090610/fields/5/last.json?api_key=MXCE7L7HZA5MAOJR";
    var url_Light = "https://api.thingspeak.com/channels/2090610/fields/6/last.json?api_key=MXCE7L7HZA5MAOJR";

    function updateValues() {
        $.getJSON(url_humidtiy, function(data) {
            var field_value = data.field1;
            $("#1").text(field_value);

            if (field_value < 25) {
                $("#Fan-button").prop("disabled", true);
                $("#Fan-button").addClass("gray-button");
                $("#Fan-button").text("Fan Button disabled, the humidity is less than 25%");
            } else {
                $("#Fan-button").prop("disabled", false);
                $("#Fan-button").removeClass("gray-button");
                updateButton();
            }
        });

        $.getJSON(url_temp, function(data) {
            var field_value = data.field2;
            $("#2").text(field_value);
        });

        $.getJSON(url_LM, function(data) {
            var field_value = data.field3;
            $("#3").text(field_value);
        });

        $.getJSON(url_Soil, function(data) {
            var field_value = data.field4;
            $("#4").text(field_value);

            if (field_value > 75) {
                $("#waterPump-button").prop("disabled", true);
                $("#waterPump-button").addClass("gray-button");
                $("#waterPump-button").text("Water pump disabled, the soil moisture is more than 75%");

            } else {
                $("#waterPump-button").prop("disabled", false);
                $("#waterPump-button").removeClass("gray-button");
                updateButton();
            }
        });

        $.getJSON(url_waterLevel, function(data) {
            var field_value = data.field5;
            $("#5").text(field_value);
        });

        $.getJSON(url_Light, function(data) {
            var field_value = data.field6;
            $("#6").text(field_value);
        });
    }


    // Call updateValues() every half second
    setInterval(updateValues, 500);

    var isOn = false;
    var fanOn = false;
    var LightOn = false;
    $("#waterPump-button").click(function() {
        if ($("#waterPump-button").prop("disabled")) {
            return;
        } else {
            isOn = !isOn;
            updateButton();
            sendData(isOn ? 1 : 0);
        }
    });

    $("#Fan-button").click(function() {
        if ($("#Fan-button").prop("disabled")) {
            return;
        } else {
            fanOn = !fanOn;
            updateButton2();
            sendData2(fanOn ? 2 : 3);
        }
    });

    $("#Light-button").click(function() {
        if ($("#Light-button").prop("disabled")) {
            return;
        } else {
            LightOn = !LightOn;
            updateButton3();
            sendData3(LightOn ? 4 : 5);
        }
    });

    function updateButton() {
        if (isOn) {
            $("#waterPump-button").removeClass("off-button");
            $("#waterPump-button").addClass("on-button");
            $("#waterPump-button").text("Water pump ON");
        } else {
            $("#waterPump-button").removeClass("on-button");
            $("#waterPump-button").addClass("off-button");
            $("#waterPump-button").text("Water pump OFF");
        }
    }

    
    function updateButton2() {
     

        if (fanOn){
            $("#Fan-button").removeClass("off-button");
            $("#Fan-button").addClass("on-button");
            $("#Fan-button").text("Fan ON");
        }else {
            $("#Fan-button").removeClass("on-button");
            $("#Fan-button").addClass("off-button");
            $("#Fan-button").text("Fan OFF");

        }
    }

    function updateButton3() {
     

        if (LightOn){
            $("#Light-button").removeClass("off-button");
            $("#Light-button").addClass("on-button");
            $("#Light-button").text("Light ON");
        }else {
            $("#Light-button").removeClass("on-button");
            $("#Light-button").addClass("off-button");
            $("#Light-button").text("Light OFF");

        }
    }

    function sendData(value) {
        var url = "https://api.thingspeak.com/update?api_key=QJAP8I7INE7QTTUJ&field1=" + value;
      
        $.ajax({
          url: url,
          type: "GET",
          success: function(data) {
            console.log("Data sent successfully.");
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error sending data: " + textStatus);
          }
        });
    }

    function sendData2(value) {
        var url = "https://api.thingspeak.com/update?api_key=MLYW1GUO9T1TWUHR&field1=" + value;
      
        $.ajax({
          url: url,
          type: "GET",
          success: function(data) {
            console.log("Data sent successfully.");
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error sending data: " + textStatus);
          }
        });
    }

    function sendData3(value) {
        var url = "https://api.thingspeak.com/update?api_key=0ILWUY2JXJ19CL9Z&field1=" + value;
      
        $.ajax({
          url: url,
          type: "GET",
          success: function(data) {
            console.log("Data sent successfully.");
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error sending data: " + textStatus);
          }
        });
    }
});