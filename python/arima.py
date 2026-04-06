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

# pake arima (1,1,1)
best_order = (1,1,1)

# ================= RETRAIN MODEL =================
final_model = ARIMA(series, order=best_order).fit()

# prediksi masa depan
forecast_test = final_model.forecast(steps=5)
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