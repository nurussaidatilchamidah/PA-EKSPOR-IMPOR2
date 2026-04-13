import warnings
warnings.filterwarnings("ignore")

import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import numpy as np
import sys
import json

data = json.loads(sys.argv[1])
series = pd.Series(data).astype(float)

# ================= MODEL =================
order = (2,1,2)

# ================= WALK FORWARD =================
history = list(series[:3])
predictions = []

for t in range(3, len(series)):
    try:
        model = ARIMA(
            history,
            order=order,
            enforce_stationarity=False,
            enforce_invertibility=False
        ).fit()

        yhat = model.forecast()[0]

    except:
        yhat = history[-1]

    predictions.append(yhat)
    history.append(series[t])

# ================= EVALUASI =================
actual = series[3:].values
pred = np.array(predictions)

min_len = min(len(actual), len(pred))
actual = actual[:min_len]
pred = pred[:min_len]

mae = np.mean(np.abs(actual - pred))
rmse = np.sqrt(np.mean((actual - pred) ** 2))

# ================= PREDIKSI MASA DEPAN =================
try:
    model_full = ARIMA(
        series,
        order=order,
        enforce_stationarity=False,
        enforce_invertibility=False
    ).fit()

    forecast_future = model_full.forecast(steps=6).tolist()

except:
    forecast_future = [series.iloc[-1]] * 6

# ================= OUTPUT =================
result = {
    "model": "ARIMA(2,1,2)",
    "mae": float(mae),
    "rmse": float(rmse),
    "prediksi_test": predictions,
    "prediksi": forecast_future
}

print(json.dumps(result))