import warnings
warnings.filterwarnings("ignore")

import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import numpy as np
import sys
import json

data = json.loads(sys.argv[1])

# ubah semua data menjadi float
series = pd.Series(data).astype(float)

train = series[:-1]
test = series[-1:]

model = ARIMA(train, order=(1,1,1))
model_fit = model.fit()

forecast = model_fit.forecast(steps=1)

mae = np.mean(np.abs(test.values - forecast.values))
rmse = np.sqrt(np.mean((test.values - forecast.values) ** 2))

result = {
    "prediksi": float(forecast.iloc[0]),
    "mae": float(mae),
    "rmse": float(rmse)
}

print(json.dumps(result))