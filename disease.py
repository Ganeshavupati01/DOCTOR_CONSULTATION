import pandas as pd
pd.set_option("display.max_columns", None)
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import accuracy_score
import warnings
warnings.filterwarnings('ignore')



data_train = pd.read_csv("Training.csv")
data_train.head()


data_test = pd.read_csv("Testing.csv")
data_test.head()


rows_train = data_train.shape[0]
cols_train = data_train.shape[1]

print(f'Rows: {rows_train}')
print(f'Columns: {cols_train}')



rows_test = data_test.shape[0]
cols_test = data_test.shape[1]

print(f'Rows: {rows_test}')
print(f'Columns: {cols_test}')



data_train = data_train.drop('Unnamed: 133', axis = 1)
data_train.head()



X_train, y_train = data_train.drop('prognosis', axis = 1), data_train['prognosis']

X_test, y_test = data_test.drop('prognosis', axis = 1), data_test['prognosis']


lr = LogisticRegression(multi_class = 'multinomial')
lr.fit(X_train, y_train)

y_pred_train = lr.predict(X_train)
y_pred_test = lr.predict(X_test)

print(f'Accuracy Train: {accuracy_score(y_train, y_pred_train):.4f}')
print(f'Accuracy Test: {accuracy_score(y_test, y_pred_test):.4f}')