import warnings
warnings.filterwarnings("ignore")

import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import numpy as np
import sys
import json

# ================= INPUT =================
data = json.loads(sys.argv[1])

series = pd.Series(data).astype(float)

# ================= MODEL =================
order = (2,1,2)

try:

    model = ARIMA(
        series,
        order=order,
        enforce_stationarity=False,
        enforce_invertibility=False
    ).fit()

    # forecast masa depan
    forecast_future = model.forecast(steps=3).tolist()

    # batasi prediksi yang tidak masuk akal
    last_value = float(series.iloc[-1])

    forecast_future = [
        float(v) if abs(v) < (last_value * 2)
        else last_value
        for v in forecast_future
    ]

    # fitted values
    fitted = model.fittedvalues

    min_len = min(len(series), len(fitted))

    actual = series[-min_len:]
    pred = fitted[-min_len:]

    mae = np.mean(np.abs(actual - pred))
    rmse = np.sqrt(np.mean((actual - pred) ** 2))

    mape = np.mean(np.abs((actual - pred) / actual)) * 100

except:

    forecast_future = [series.iloc[-1]] * 3

    mae = 0
    rmse = 0
    mape = 0

# ================= OUTPUT =================
result = {
    "model": "ARIMA(2,1,2)",
    "mae": float(mae),
    "rmse": float(rmse),
    "mape": float(mape),
    "prediksi": forecast_future
}

print(json.dumps(result))