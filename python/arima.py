import warnings
warnings.filterwarnings("ignore")

import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import numpy as np
import sys
import json

data = json.loads(sys.argv[1])

series = pd.Series(data).astype(float)

# split data
train = series[:-3]
test = series[-3:]

best_aic = float("inf")
best_order = None
best_model = None

# cari model ARIMA terbaik
for p in range(0,3):
    for d in range(0,2):
        for q in range(0,3):
            try:
                model = ARIMA(train, order=(p,d,q))
                model_fit = model.fit()

                if model_fit.aic < best_aic:
                    best_aic = model_fit.aic
                    best_order = (p,d,q)
                    best_model = model_fit
            except:
                continue

# ================= RETRAIN MODEL =================
final_model = ARIMA(series, order=best_order).fit()

# prediksi masa depan
forecast_test = final_model.forecast(steps=1)

actual = test.values

mae = np.mean(np.abs(test - forecast_test))
rmse = np.sqrt(np.mean((test - forecast_test) ** 2))

mae = float(mae) if not np.isnan(mae) else 0.0
rmse = float(rmse) if not np.isnan(rmse) else 0.0

result = {
    "prediksi": forecast_test.tolist(),
    "mae": mae,
    "rmse": rmse,
    "model": str(best_order)
}

print(json.dumps(result))