# Bus Arrival App
This simple webpage uses API endpoints provided by LTA's DataMall. [The Documentation](https://datamall.lta.gov.sg/content/dam/datamall/datasets/LTA_DataMall_API_User_Guide.pdf)

In order to use the API, a sign-up is required to obtain an API key.

The flow is as follows:
1. Process a Bus Stop number in a form.
2. Send the Bus Stop number using the `BusArrivalV2` endpoint.
3. The object returned will have a `Services` array. Each element in the array has `ServiceNo` property, which can be used to populate buttons. Each button, when clicked, will hide all services and display only the bus arrivals related to the Service clicked.
4. Each element in the `Services` array has a `NextBus` object, and optionally, a `NextBus2` and `NextBus3` object.
5. `NextBus` object has a `EstimatedArrival` property, which is a DateTime. This can be displayed for the Service.
