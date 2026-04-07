import warnings
warnings.filterwarnings("ignore")

import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import numpy as np
import sys
import json

data = json.loads(sys.argv[1])

series = pd.Series(data).astype(float)

# ================= SPLIT DATA =================
train = series[:-3]
test = series[-3:]

# ================= MODEL ARIMA =================
order = (1,1,1)

# model untuk evaluasi (pakai TRAIN)
model_train = ARIMA(train, order=order).fit()

# model untuk prediksi masa depan (pakai SEMUA DATA)
model_full = ARIMA(series, order=order).fit()

# ================= EVALUASI =================

# prediksi untuk data test (HARUS sama panjang)
forecast_test = model_train.forecast(steps=len(test))

actual = test.values

mae = np.mean(np.abs(actual - forecast_test))
rmse = np.sqrt(np.mean((actual - forecast_test) ** 2))

# ================= PREDIKSI MASA DEPAN =================

forecast_future = model_full.forecast(steps=5)

# handle NaN
mae = float(mae) if not np.isnan(mae) else 0.0
rmse = float(rmse) if not np.isnan(rmse) else 0.0

# ================= OUTPUT =================

result = {
    "prediksi": forecast_future.tolist(),
    "mae": mae,
    "rmse": rmse,
    "model": str(order)
}

print(json.dumps(result))